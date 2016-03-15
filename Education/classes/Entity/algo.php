<?php

namespace Educ\Entity;

class algo {
    private  $dataImg;
    private $offset;                 // deprecated!
    private $lengthline;
    private $head;
    private $width;
    private $count = 0;
    public $coord = ['debut'=>0, 'fin'=>0];
    public $cells = [];
    private $line = 520;
    private $find = false;
    private  $srcfile = null;

    public function  construct__()
    {
    }
    public function  readCell($decalX, $decalY) {
        $file = 'temp/CellMn.bmp';
        $this->head = file_get_contents($file, NULL, NULL, 0, 62);
        $this->dataImg = file_get_contents($file, NULL, NULL, 62);
        $this->width = $this->getInfo('largeur');
        $this->lengthline = $this->getFormat($this->width);
        $wordCell = [];
        for($y = $decalY, $Comp = 0; $Comp < 6; $y += 106, $Comp++) {
            //$wordCell[$Comp] ='';
            for ($x = 1; $x < 6; $x++) {
                $fill = $this->checkcontent($decalX+40 * ($x-1), $y);
                $wordCell[$Comp*5+$x]=$fill;
            }
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
        $this->lengthline = $this->getFormat($this->width);
        $jump = $this->getFormat($this->width, true);
        $newImgSize = $this->lengthline * $this->getInfo('hauteur');

        // modification du header
        $head = $this->head;
        $change = [$newImgSize+$newHeadSize, $newHeadSize, 40, 1, $newImgSize, 0];
        foreach ($change as $key=>$value) {
            if($value<65536 && $key!=0) {$long=2; $format='v';}  else {$long=4; $format='V';}
            $head = substr_replace($head, pack($format, $value), $posInfo[$key], $long);
        }
        $head .= $endhead;

 /*
        echo '<br>' . bin2hex($this->head) . '<br>';
        echo bin2hex($head) . '<br>';
        echo '<br>ancienne taille fichier: '. $this->getInfo('fichier_taille');
        echo '<br>nouvelle taille image: '. $newImgSize;
        echo '<br>resolution H: '. $this->width;
        echo '<br>octets par ligne: '. $this->lengthline;
        echo '<br>saut: ' . $jump . '<br><br>';                 */

          fwrite($newfile, $head);

        // traitement de chaque ligne de l'image, repositionnement du pointeur de fichier en fonction du codage d'origine des lignes (octets vides à ignorer)
        $total='';
        for($z=0; $z<$this->getInfo('hauteur'); $z++) {
           if($z>0 && $jump>0) {fseek($this->srcfile, ftell($this->srcfile)+$jump);}

           // extraction d'une seule ligne
            $imageline = fread($this->srcfile, $this->width*3);
            for ($i = 0; $i < $this->width; $i ++) {
                $pix = bin2hex(substr($imageline, $i*3, 3));
                if (hexdec($pix)<10000000) {                         // 1:2 = 8 388 608
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
           $add = strlen($store);
           $total += $add;
           fwrite($newfile, $store);
       }
      //  echo 'Fichier converti, '. $total .' octets ont ete enregistres!<br>';
        fclose($this->srcfile);
        fclose($newfile);
       unlink($file);
    }
    public  function  getdecalage() {
        $map = [0,0,1,0,1,1,0,1,2,0,2,1,1,2,0,2,2,2] ;
        $goodpos=0; $level=1; $excellent=0;  $i=0;
        $spare = $strike = 0;   $decal = [];  $bloc=0;
        while($i<count($map) && $goodpos<$level || $excellent<4) {
             var_dump($i);
            $analyse = $this->readCell($map[$i],$map[$i+1]);
            foreach($analyse as $key => $value) {
                if($value >60) {unset($analyse[$key]);}
            }
            $goodpos = count($analyse);
            $excellent = 0;
            $level = $goodpos;      //*2/3?
            foreach($analyse as $value) {
                if($value > 5 && $value <20) {$goodpos--;}
                if($value==0) {$excellent++;}
            }
            if($goodpos==$level && $excellent>2 && $strike==0) {$strike = (($i/2)+1 ); echo 'STRIKE!';}
            if($goodpos==$level && $strike==0 && $spare==0) {$spare = (($i/2)+1 ); echo 'SPARE!';}
            /*    echo '<br>test= ' . (($i/2)+1);
                echo '<br>excellent= ' . $excellent;
                echo '<br>level= ' . $level;
                echo '<br>goodpos= ' . $goodpos. '<br>';
                var_dump($analyse);        */
            $i+=2;
        }
        if($i==count($map)) {
            if($strike!=0) {
                $decal[0] = $map[($strike-1)*2];
                $decal[1] = $map[($strike-1)*2+1];
                $bloc = $strike;
            }
            if($spare!=0 && $strike==0) {
                $decal[0] = $map[($spare-1)*2];
                $decal[1] = $map[($spare-1)*2+1];
                $bloc=$spare;
            }
            if($strike==0 && $spare==0) {echo 'What\'s the loadMeans!';$bloc='not found!';}
        } else {
            echo'SUPERBALL!';
            $decal[0] = $map[$i-2];
            $decal[1] = $map[($i-1)];
            $bloc=$i/2;
        }
        echo '<br>bloc ideal: ' . $bloc;
        echo '<br>le decalage est de: '  . $decal[0] .' et '.  $decal[1];
        echo '<br>le placement a ete optimise! Let\'s continue!' ;
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
        var_dump($vertic);
        for ($i = 0; $i < strlen($vertic); $i++) {
            $pix = substr($vertic, $i, 1);
            if ($pix == 0) {
                $result++;
            }
        }
        $result = ($result / 33) * 100 .'%';
        return $result;
    }
    public function getline($numline)         // toujours ajouter 1 par rapport à paint pour ajuster l'axe vertical    (ligne 0 n'existe pas pour Algo)
    {
        $file = 'temp/CellMn.bmp';
        $this->head = file_get_contents($file, NULL, NULL, 0, 62);
        $this->dataImg = file_get_contents($file, NULL, NULL, 62);
        $this->width = $this->getInfo('largeur');
        $this->lengthline = $this->getFormat($this->width);
        /********************************************/
        $result = '';
        $start = $this->lengthline * $numline;
        $this->offset = $this->getInfo('image_taille') - $start;
        $line = bin2hex(substr($this->dataImg, $this->offset, $this->lengthline));
        for ($i = 0; $i < strlen($line); $i += 2) {
            $offset = hexdec(substr($line, $i, 2));
            $binary = $this->binExtract($offset);
            $result .= $binary;
        }

       // var_dump($result);
        return $result;
    }
    public function checkline($line, $pos=0)
    {

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
                            $this->coord['debut'] = $tampon + $pos;
                            $this->coord['fin'] = $offset + $pos - 1;
                            $this->find = true;
                            $result[0] = $this->coord['debut'] + 5;
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
        switch ($data) {
            case 'largeur':
                $offset = 18;
                break;
            case 'hauteur':
                $offset = 22;
                break;
            case 'profondeur':          // attention ->word et non qword
                $offset = 28;
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
        $qword = substr($this->head, $offset, 4);
        $result = unpack('V', $qword);
        return $result[1];
    }
    function isMultiple($nombre, $multiple){
        if(($nombre % $multiple) == 0)  {return true;}
        else {return false;}
    }
    private function getFormat($largeur, $mode=false) {
        $i =$result=$base=0;
        if($mode) {$base = $largeur *3;} else {$base = (int)($largeur/8);}
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
        // echo base_convert('eb7bdef7bac8',16,2) . '</br>';        // limité à 13 caractères!
        return $binstring;

    }
    private function findcell() {
        while(!$this->find) {
            $this->line++;
            $this->checkline($this->line);
        }
        echo $this->line;
        if($this->count>0) {$this->checkline($this->line, $this->coord['fin']);}
        var_dump($this->coord);
        $caf = $this->coord['debut'];
        $toto = $this->getvertical($caf, $this->line);
        $titi =  $this->getvertical($caf-1, $this->line);
        echo $toto; echo ' ' . $titi;
        if($toto-$titi>=75) {$this->cells[$this->count]['abs'] = $caf ;}
        if($titi-$toto>=75)  {$this->cells[$this->count]['abs'] = $caf-1 ;}
        $this->cells[$this->count]['ord'] = $this->line;
        $this->count++;
       // if($this->coord['fin']>220) {$this->line++;}
        var_dump($this->cells);
     }
         /* function decompose($word) {
          $byte = [];
          $bit4 = [];
          $i=0;   $j=0;
           foreach ($word as $value)    {
              $byte[$j] = (int)($value/256);
              $byte[$j+1] = $value%256;
              $j+=2;
          }
          foreach ($byte as $value) {
              $bit4[$i] = (int)($value/16);
              $bit4[$i+1] =  $value%16;
              $i+=2;
          }
          return $bit4;
      }     */
}

