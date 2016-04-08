var book = {

    bdd: Object.create(ajax),
    discSelect: null,
    catSelect: null,
    compSelect: null,
    studSelect: null,
    panel: null,
    table: null,
    create: false,
    dscpID: 1,
    catInd: 1,
    compID: 0,
    stInd: 0,
    add:0,
    classID: 53,
    classContent: [],
    doc:null,
    choice:[],
    tempbind: null,
    tampon:[],
    catID: [],
    means: [],

    init: function () {

        this.discSelect = document.querySelector('#S1');
        this.catSelect = document.querySelector('#S2');
        this.table = document.querySelector('.tableread');
        this.discSelect.addEventListener('change', this.selectDis.bind(this));
        this.catSelect.addEventListener('change', this.selectCat.bind(this));
        this.discSelect.addEventListener('dataReady', this.printCat.bind(this));
        this.catSelect.addEventListener('dataReady', this.printCptce.bind(this));

        if(this.create) {
            var addbut = document.querySelector('#add');
            var savebut = document.querySelector('#save');
            var supbut = document.querySelector('#sup');
            this.compSelect = document.querySelector('#S3') ;
            addbut.addEventListener('click', this.addContent.bind(this));
            savebut.addEventListener('click', this.savedoc.bind(this));
            supbut.addEventListener('click', this.removeContent.bind(this));
            this.compSelect.addEventListener('change', this.selectComp.bind(this));
       }   else  {
            this.tempbind = this.loadClass.bind(this);
            var graphbut = document.querySelector('#S4');
            this.studSelect = document.querySelectorAll('.fleche');
            this.panel = document.querySelector('.student');
            this.page = document.querySelector('#page');
            this.table.addEventListener('dataReady', this.renderTab.bind(this));
            this.panel.addEventListener('dataReady', this.tempbind);
            this.page.addEventListener('dataReady', this.loadMeans.bind(this));
            graphbut.addEventListener('click', this.callGraph.bind(this));
            graphbut.addEventListener('dataReady', this.printChart.bind(this));
            for (var i = 0; i < this.studSelect.length; i++) {
                this.studSelect[i].addEventListener('click', this.selectStudent.bind(this));/* passage de paramètres dans la fonction bind (si nécessaire) et non pas dans la fonction appellée!*/
            }
            this.bdd.init('#page', false, 'ajax/compensation.php');
        }
    },
    loadMeans: function() {
        for (var i=0; i<this.bdd.getdata().length; i++) {
            this.means[i] = this.bdd.getdata()[i];
        }
        this.bdd.init('.student', true, 'ajax/numStudent.php', 'class=' + this.classID);
    },
    loadClass: function() {
        var json = this.bdd.getdata();
        this.panel.removeEventListener('dataReady', this.tempbind);
        this.panel.addEventListener('dataReady', this.printStudent.bind(this));
        for (var i=0; i<json.length; i++) {
            this.classContent.push(json[i]);
        }
      // this.bdd.init('.tableread', true, 'ajax/validate.php', 'id=' + this.classContent[this.stInd] + '&c=' + this.catInd);
    },
    selectDis: function () {
        var newVal = this.discSelect.value;
        this.catInd = 1;
        if(this.create) {this.compSelect.innerHTML ='';}
        for (var i = 1; i < this.discSelect.children.length; i++) {
            if (this.discSelect.children[i].value === newVal) {
                this.dscpID = i;
                break;
            }
        }
        this.bdd.init('#S1', true, 'ajax/categorie.php', 'd=' + this.dscpID);
    },
    printCat: function () {
        var html = '<option></option>';
        for (var i = 0; i < this.bdd.getdata().length; i++) {
            html += '<option>' + this.bdd.getdata()[i].intitule + '</option>';
            this.catID[i+1] = this.bdd.getdata()[i].id;
        }
        this.catSelect.innerHTML = html;
    },
    selectCat: function () {
        var newVal = this.catSelect.value;
        for (var i = 1; i < this.catSelect.children.length; i++) {
            if (this.catSelect.children[i].value === newVal) {
                this.catInd = i;
                break;
            }
        }
        this.bdd.init('#S2', true, 'ajax/competence.php', 'd=' + this.dscpID + '&c=' +  this.catID[this.catInd]);
    },
    selectComp: function () {
        for(var i=1; i< this.compSelect.children.length; i++) {
            if(this.compSelect.children[i].value === this.compSelect.value) {
                this.compID = this.bdd.getdata()[i-1].id;
                break;
            }
        }
    },
    printCptce: function () {
        this.tampon.splice(0);
        if(this.create) {
            this.compSelect = document.querySelector('#S3');
            var html = '<option></option>';
            for (var i = 0 ; i < this.bdd.getdata().length ; i++) {
                html += '<option>' + this.bdd.getdata()[i].intitule + '</option>';
            }
            this.compSelect.innerHTML = html;
        }  else  {
            for ( i = 0 ; i < this.bdd.getdata().length ; i++) {
                this.tampon[i]=[];
                this.tampon[i]['intitule'] = this.bdd.getdata()[i].intitule;
                this.tampon[i]['id'] = this.bdd.getdata()[i].id;
            }
            this.bdd.init('.tableread', true, 'ajax/validate.php', 'id=' + this.classContent[this.stInd] + '&c=' + this.catID[this.catInd]);
        }
    },
    renderTab: function() {
        var cptce = this.bdd.getdata();
        var items= [];
        for ( i = 0; i <this.tampon.length; i++) {
          items[i] = this.tampon[i];
         }
        cptce.sort(function(a, b) {
            if (a.FKcompetence < b.FKcompetence) {
                return -1;
            } else if (a.FKcompetence > b.FKcompetence) {
                return 1;
            } else {
                return 0;
            }
        });
        var html = '<h3>' + this.catSelect.value + '</h3><table class="main"><tr><th>Etre capable de</th><th>Niv</th><th>Dates de validation</th></tr>';
        for (var i = 0, j=0; i <this.tampon.length && j<cptce.length; i++) {
            if (cptce[j].FKcompetence == this.tampon[i]['id']) {
                for (var property in cptce[j]) {
                    if(property == 'first' || property == 'second' || property== 'last')  {
                        if(cptce[j][property] === '0000-00-00') {
                            cptce[j][property] = '<p class="false red">X</p>';
                        } else {
                            var workdate = new Date(cptce[j][property]);
                            cptce[j][property] = ("0" + (workdate.getDate() ).toString()  ).substr(-2) + "/" + ("0" + (workdate.getMonth() + 1).toString()).substr(-2)  + "/" + (workdate.getFullYear().toString());
                        }
                    }
                }
                html += '<tr><td>' + (j+1) + '/ ' + this.tampon[i]['intitule'] + '</td><td class="level"></td><td  class="date"><table><tr><td>' + cptce[j].first + ' <br>' + this.means[cptce[j].FKcompensationA - 1]+ '</td><td>' + cptce[j].second + ' <br>' +  this.means[cptce[j].FKcompensationB - 1] + '</td><td>' + cptce[j].last + ' <br>' + this.means[cptce[j].FKcompensationC - 1]+ '</td></tr></table></td></tr>';
                items.splice(i, 1);    // équivaut à la méthode unset PHP, delete array[i] doesn't work!
                 j++;
            }
        }
         for ( i = 0; i <items.length; i++) {
             html += '<tr><td>' + (i + cptce.length + 1) + '/ ' + items[i]['intitule'] + '</td><td class="redBg"></td><td  class="date"><table><tr></tr></table></tr>';
        }
        html += '</table>';
        this.table.innerHTML = html;
        var niveau = document.querySelectorAll('.level');
        if(niveau.length > 0) {
            for ( i = 0; i <cptce.length; i++) {
                switch (cptce[i].FKetat) {
                    case '2':
                        niveau[i].classList.add('orange');
                        break;
                    case '3':
                        niveau[i].classList.add('yellow');
                        break;
                    case '4':
                        niveau[i].classList.add('green');
                        break;
                }
            }
        }
    },
    selectStudent: function (evt) {

        var numStud = this.classContent.length;
        var cible = evt.target;
        for (var i = 0; i < numStud; i++) {
            if (cible == this.studSelect[i]) {
                cible = i;
            }
        }
        if (cible == 1) {
            if (this.stInd < numStud-1) {
                this.stInd++
            } else {
                this.stInd = 0
            }
        }
        if (cible == 0) {
            if (this.stInd > 0) {
                this.stInd--
            } else {
                this.stInd = numStud-1
            }
        }
       this.bdd.init('.student', true, 'ajax/selectStudent.php', 'stud=' + this.classContent[this.stInd] + '&class=' + this.classID);
    },
    printStudent: function () {
       // this.bdd.getdata().total ==> nbr eleves
        var html = '<h2>CLASSE ' + this.classID + '</h2>';
        if (this.bdd.getdata().photo == '') {this.bdd.getdata().photo = 'nophoto.jpg';}
        html += '<div class="photo"><img src="upload/' + this.bdd.getdata().photo + '" alt="photo indisponible"></div> <div class="fleche"></div> <div class="fleche droite"></div><div class="info"><p>Nom: <span>' + this.bdd.getdata().nom + '</span></p><p>Prénom: <span>' + this.bdd.getdata().prenom + '</span></p><p>Adresse: <span>' + this.bdd.getdata().num + ', ' + this.bdd.getdata().voie + '</span></p><p><span>' + this.bdd.getdata().complement + '</span></p><p><span>' + this.bdd.getdata().cpost + ' ' + this.bdd.getdata().ville + '</span></p><p>Age: <span>' + this.bdd.getdata().age + '</span></p><p>Réussite: <span>' + this.bdd.getdata().succes+ '%</span></p></div>';
        this.panel.innerHTML = html;
        this.bdd.init('.tableread', true, 'ajax/validate.php', 'id=' + this.classContent[this.stInd] + '&c=' + this.catID[this.catInd]);
        // l'événement click n'est plus écouté, les flèches ont disparu
        this.studSelect = document.querySelectorAll('.fleche');
        for (var i = 0; i < this.studSelect.length; i++) {
            this.studSelect[i].addEventListener('click', this.selectStudent.bind(this));
        }
    },
    addContent:function() {
        var notPut = true;   var selectOk = true;
        if(this.dscpID == 0 || this.catInd == 0 || this.compID == 0) {
            selectOk = false;
        } else {
            console.log('dscp=' + this.dscpID +'/cat=' + this.catInd +'/comp=' + this.compID);
        }
        for(var i=0; i<this.add; i++) {
            if(this.choice[i] == this.compID) {notPut = false; console.log(i+1); break;}
        }
        if(notPut && selectOk) {
            var field = document.createElement('tr');
            if(this.add == 0) {
                this.doc = document.querySelector('table');
                this.doc.innerHTML = '<th></th><th>Discipline</th><th>Catégorie</th><th>Compétence</th>';
            }
            this.choice[this.add] = this.compID;
            field.innerHTML =  '<td>' + (this.add+1) + '</td><td>' + this.discSelect.value + '</td><td>' + this.catSelect.value + '</td><td>'  +
                this.compSelect.value + '</td>' ;
            this.doc.appendChild(field);
            this.add ++;
        }
    },
    removeContent:function() {
        this.doc.removeChild(this.doc.lastElementChild);
        this.add--;
        if(this.add == 0) {
            this.doc.innerHTML = '';
        }
    },
    savedoc: function() {
        var params = 'data[]=' + this.classID + '&' + 'data[]=' + this.add + '&';
        for(var i=0; i<this.add; i++) {
            params += 'data[]=' + this.choice[i];
            if (i != this.add-1) {params += '&';}
        }
        console.log(params);
        window.location.href = 'sendpdf.php?' + params;
    },
     insertParam: function(key, value)  {
    key = encodeURI(key); value = encodeURI(value);
    var kvp = document.location.search.substr(1).split('&');
    var i=kvp.length; var x; while(i--) {
        x = kvp[i].split('=');
        if (x[0]==key) {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }
    if(i<0) {kvp[kvp.length] = [key,value].join('=');}
    document.location.search = kvp.join('&');
    },
    replaceAt:function(string, index, character) {
    return string.substr(0, index-1) + character + string.substring(index);
    },
    callGraph: function() {
        this.bdd.init('#S4', true, 'ajax/chart.php', 'stud=' + this.classContent[this.stInd]);
    },
    printChart: function() {
        console.log(this.bdd.getdata());
        this.table.innerHTML = '<canvas id="myChart" width="750" height="750"></canvas>';
        var ctx = document.querySelector('#myChart').getContext("2d");
        // graph.init(this.bdd.getdata());
        return new Chart(ctx).Radar(graph, {
                pointLabelFontSize: 15,
                pointLabelFontStyle: 'bold',
                pointLabelFontColor: 'black' }
        );
    },
     selectElement: function(evt) {
        var cible = evt.target;
        if(cible.classList.contains('action')) {
            cible.classList.remove('action');
            for(var key in this.autovalidate) {
                var value = this.autovalidate[key];
                 if(value == cible.id ) {this.autovalidate.splice(key, 1);}
            }
        } else {
            cible.classList.add('action');
            this.autovalidate.push(cible.id);
        }
        if(this.autovalidate.length>0 && this.query.classList.contains('invisible')) {
            this.query.classList.remove('invisible');
        }
        if(this.autovalidate.length == 0 && !this.query.classList.contains('invisible')) {
            this.query.classList.add('invisible');
        }
    },
    autovalid: function() {
        var params = 'stud=' + this.classContent[this.stInd] + '&';
        for(var i=0; i<this.autovalidate.length; i++) {
            params += 'data[]=' + this.autovalidate[i];
            if (this.autovalidate.length != i+1) {params += '&';}
        }
        this.autovalidate = [];
        this.bdd.init('article button', true, 'ajax/autovalidate.php', params);
    },
    reload: function() {
        console.log(this.bdd.getdata());
        this.bdd.init('.tableread', true, 'ajax/validate.php', 'id=' + this.classContent[this.stInd] + '&c=' + this.catInd);
        }
};



