<?php

namespace Educ\Entity;

class algo {
    private  $dataImg;
    private $offset;
    private $lengthline;
    private $head;
    private $width;
    private $color;
    private $find = false;
    private $srcfile = null;

    public function  construct__()
    {
    }
    public function  readCell($item) {
        $file = 'temp/CellMn.bmp';
        $this->head = file_get_contents($file, NULL, NULL, 0, 62);
        $this->dataImg = file_get_contents($file, NULL, NULL, 62);
        $this->width = $this->getInfo('largeur');
        $this->color = $this->getInfo('profondeur')/8;
        $this->lengthline = $this->getFormat($this->width);

        $wordCell = [];
        $pos = $this->getposition($item*100);
        for ($x = 1; $x < 6; $x++) {
                $fill = $this->checkcontent($pos[0] + 40 * ($x-1), $pos[1]);
                $wordCell[$x]=$fill;
        }
        return $wordCell;
    }
    public  function convert_to_monochrome() {
        $file = 'temp/Cell.bmp';
        $byteExtract=[];  $binaryBuild =[];  $last=0;
        $endhead = pack('c*', 0, 0, 0, 0, 255, 255, 255, 0);
        $posInfo = [2, 10, 14, 28, 34, 36];       // taille fichier, offset image, profondeur couleur, taille image
        $newHeadSize = 62;
        $this->srcfile = fopen($file, "r");
        $racine = substr($file, 0, -4);
        $newfile = fopen($racine. 'Mn.bmp', "w");
        $this->head =  fread($this->srcfile, 54);
        $offsImg = $this->getInfo('image_position');
        fseek($this->srcfile, $offsImg);
        $this->width = $this->getInfo('largeur');
        $this->lengthline = $this->getFormat();
        $jump = $this->getFormat(true);
        $newImgSize = $this->lengthline * $this->getInfo('hauteur');
        $this->color = $this->getInfo('profondeur')/8;

        // modification du header
        $head = $this->head;
        $change = [$newImgSize+$newHeadSize, $newHeadSize, 40, 1, $newImgSize, 0];
        foreach ($change as $key=>$value) {
            if($value<65536 && $key!=0) {$long=2; $format='v';}  else {$long=4; $format='V';}
            $head = substr_replace($head, pack($format, $value), $posInfo[$key], $long);
        }
        $head .= $endhead;
        fwrite($newfile, $head);

        // traitement de chaque ligne de l'image, repositionnement du pointeur de fichier en fonction du codage d'origine des lignes (octets vides à ignorer)
        for($z=0; $z<$this->getInfo('hauteur'); $z++) {
           if($z>0 && $jump>0) {fseek($this->srcfile, ftell($this->srcfile)+$jump);}

           // extraction d'une seule ligne
            $imageline = fread($this->srcfile, $this->width*$this->color);
            for ($i = 0; $i < $this->width; $i ++) {
                $pix = bin2hex(substr($imageline, $i*$this->color, $this->color));
                if (hexdec($pix) < 0xee6b2800) {    // 4000 000 000
                    $byteExtract[$i]= 0;
                }else {
                    $byteExtract[$i]=1;
                }
            }
           unset($binaryBuild);          // very important!
            for($byte=0; $byte*8<$this->width; $byte++) {
                $binaryBuild[$byte] = '';
                for ($i = 0; $i < 8; $i++) {
                    $index =  $byte*8+$i;
                    if($index==$this->width) {
                        $last = count($binaryBuild)-1;
                        $empty = 8 - strlen($binaryBuild[$last]);
                        if($empty != 0) {
                            for($i=0; $i<$empty; $i++)  {
                                $binaryBuild[$last].= '0';
                            }
                        }
                        break;
                    }
                    $binaryBuild[$byte] .= $byteExtract[$index];
                }
            }
            for($t=$last; $t<$this->lengthline-1; $t++) {
                $binaryBuild[$t+1] = '00000000';
            }
           $store='' ;
            foreach($binaryBuild as $value) {
                $data = $this->getIntValue($value);
                $store .= pack("c", $data);
            }
           fwrite($newfile, $store);
       }
        fclose($this->srcfile);
        fclose($newfile);
        unlink($file);
    }
    public  function pass_to_black() {
        $file = 'temp/Qrcod.bmp';
        $this->srcfile = fopen($file, "r+");
        $this->head =  fread($this->srcfile, 54);
        $offsImg = $this->getInfo('image_position');
        fseek($this->srcfile, $offsImg);
        $this->width = $this->getInfo('largeur');
        $this->color = $this->getInfo('profondeur')/8;
        $this->lengthline = $this->width*$this->color;

        $white_pix = ''; $black_pix = '';
        for($i=0; $i<$this->color; $i++) {
            $white_pix .= 'ff';
            $black_pix .= '00';
        }
        for($z=0; $z<$this->getInfo('hauteur'); $z++) {
            // extraction d'une seule ligne

            $store='' ;
            $imageline = fread($this->srcfile, $this->lengthline);
            for ($i = 0; $i < $this->width; $i ++) {
                $pix = bin2hex(substr($imageline, $i*$this->color, $this->color));

                if (hexdec($pix) > 0xd09dc300) {       // 3500000000
                    $store .= pack('h*', $white_pix);
                } else {
                    $store .= pack('h*', $black_pix);
                }
            }
            fseek($this->srcfile, ftell($this->srcfile) - $this->lengthline);
            fwrite($this->srcfile, $store);
        }
        fclose($this->srcfile);
        exec("convert " . $file . " temp/Qrcod.png");
        unlink($file);
    }
    private  function  getposition($line) {
        $decal = [];
        while ($decal == null) {
            $line++;
            $decal = $this->checkline($line);
        }
        if($this->getvertical($decal[0]-5, $decal[1]-5) < 75) {$decal[0]++;}
        return $decal;
    }
    private function  getpix($x, $y) {
        $line = $this->getline($y);
        $pix = substr($line, $x, 1);
        return $pix;
    }

    private function getvertical($x, $y)
    {
        $vertic = '';
        $result = 0;
        for ($i = 0; $i < 33; $i++) {
            $vertic .= $this->getpix($x, $y + $i);
        }
        for ($i = 0; $i < strlen($vertic); $i++) {
            $pix = substr($vertic, $i, 1);
            if ($pix == '0') {
                $result++;
            }
        }
        $result = (int)($result/33*100);
         return $result;
    }
    private function getline($numline)
    {
        $result = '';
        $start = $this->lengthline * $numline;
        $this->offset = $this->getInfo('image_taille') - $start;
        $line = bin2hex(substr($this->dataImg, $this->offset, $this->lengthline));
        for ($i = 0; $i < strlen($line); $i += 2) {
            $offset = hexdec(substr($line, $i, 2));
            $binary = $this->binExtract($offset);
            $result .= $binary;
        }
        return $result;
    }
    private function checkline($line, $pos=0)
    {
        $this->find = false;
        $content = substr($this->getline($line), $pos);
        $pix = [];   $result=[];
        $last = 2;
        $tampon = null;
        for ($i = 0; $i < strlen($content); $i++) {
            $pix[$i] = substr($content, $i, 1);
        }
        foreach ($pix as $offset => $value) {
                if ($last != 2 && $last != $value && !$this->find) {
                    if ($last == 0 && $value == 1) {
                        if ($offset - $tampon >= 30) {
                            $this->find = true;
                            $result[0] = $tampon + $pos + 5;
                            $result[1] = $line + 5;
                        }
                    }
                    if (($last == 1) && ($value == 0)) {
                        $tampon = $offset;
                    }
                }
                $last = $value;
            }
        return $result;
    }
    private function  checkcontent($x, $y)
    {
        $fillbox = 0;
        $pix = [];
        $size = 22;
        $height = 23;

        for ($i = 0; $i < $height; $i++) {
            $line = $this->getline($y + $i);
            $line = substr($line, $x, $size);
            for ($j = 0; $j < strlen($line); $j++) {
                $result = substr($line, $j, 1);
                $pix[$j] = $result;
            }
            foreach ($pix as $offset => $value) {
                if ($value == 0) {
                    $fillbox++;
                }
            }
        }
        $fillbox = (int)($fillbox / ($size * $height) * 100);
        return $fillbox;
    }
    public  function getIntValue($binstring) {
        $value=0;
        $inc = strlen($binstring);
        for($i=0; $i<$inc; $i++) {
        $pix = intval(substr($binstring, $inc-1-$i, 1));
        $value += $pix *pow(2, $i);
        }
        return $value;
    }
    private function  getInfo($data)
    {
        $offset = null;
        $capacity = true;
        switch ($data) {
            case 'largeur':
                $offset = 18;
                break;
            case 'hauteur':
                $offset = 22;
                break;
            case 'profondeur':
                $offset = 28;
                $capacity = false;
                break;
            case 'image_position':
                $offset = 10;
                break;
            case 'image_taille':
                $offset = 34;
                break;
            case 'fichier_taille':
                $offset = 2;
                break;
        }
        if ($capacity) {
            $qword = substr($this->head, $offset, 4);
            $result = unpack('V', $qword);
            return $result[1];
        } else {
            $word = substr($this->head, $offset, 2);
            $result = unpack('v', $word);
            return $result[1];
        }
    }
    function isMultiple($nombre, $multiple){
        if(($nombre % $multiple) == 0)  {return true;}
        else {return false;}
    }
    private function getFormat($mode=false) {
        $i = $result = $base = 0;
        if($mode) {$base = $this->width * $this->color;} else {$base = (int)($this->width/8);}
        while(!$this->isMultiple($base+$i, 4))  {
            $i++;
        }
        if($mode) {$result = $i;} else {$result = $base+$i;}
        return $result;
    }
    private function  def($int)
    {
        $result = null;
        switch ($int) {
            case 0:
                $result = 'black';
                break;
            case 12:
                $result = 'blue';
                break;
            case 15:
                $result = 'white';
        }
        return $result;
    }

    private function binExtract($byte)
    {
        $binstring = '';
        for ($i = 2; $i <= 256; $i *= 2) {
            $result = intval($byte / (256 / $i));
            $byte = $byte % (256 / $i);
            $binstring .= $result;
        }
        return $binstring;
    }

}

