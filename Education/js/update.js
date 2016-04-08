 var Consol = {
    bdd: Object.create(ajax),
    nbrPage: [],
    nbrFile: null,
    CurrentPage:0,
    CurrentFile:1,
    screen: null,
    butShow: null,
    html: '',
    init : function() {
        this.butShow = document.querySelector('#showme');
        var butHide = document.querySelector('#hideme');
        this.screen = document.querySelector('.console');
        this.screen.addEventListener('dataReady', this.readfile.bind(this));
        butHide.addEventListener('click', this.hide.bind(this));
        this.butShow.addEventListener('click', this.show.bind(this));
       // this.ajax();
    },
    readfile: function() {
        var html = '<p>> Extraction des résultas de la page terminée.</p>';
        var contentSupport = document.querySelector('.tableread');
        this.html +=  this.bdd.getdata();
        contentSupport.innerHTML = this.html;
        this.CurrentPage++;
        if(this.CurrentPage < this.nbrPage[this.CurrentFile-1]) {
            html += '<p>> Page ' + (this.CurrentPage + 1) + ' - chargement , veuillez patienter...</p>';
            this.ajax();
        } else {
            html += '<p>> Lecture complète du fichier accomplie!</p><br>';
            this.CurrentFile ++;
            this.CurrentPage = 0;
            if(this.CurrentFile < this.nbrFile+1) {
                this.ajax();
                html += '<p>> Ouverture du fichier n° ' + this.CurrentFile + '</p>';
                html += '<p>> Page 1 - chargement , veuillez patienter...</p>';
            }
        }
        this.screen.children[1].innerHTML += html;     // écritures équivalentes => childNodes[3] || firstElementChild.nextElementSibling
    },
    ajax: function() {
       this.bdd.init('.console', true, 'ajax/update.php', 'file=' + this.CurrentFile + '&page=' + this.CurrentPage);
    },
    hide: function() {
        this.screen.classList.add('invisible');
        this.butShow.classList.remove('invisible');
        this.screen.parentNode.firstElementChild.classList.remove('invisible');
        this.screen.parentNode.style.height = '53rem';
    },
    show: function() {
        this.screen.classList.remove('invisible');
        this.butShow.classList.add('invisible');
        this.screen.parentNode.firstElementChild.classList.add('invisible');
        this.screen.parentNode.style.height = '66rem';
    }
};
