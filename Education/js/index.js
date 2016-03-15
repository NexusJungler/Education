var Skynet = {

    page: window.location.href,
    error: false,
    login: 0,
    success: false,
    form: null,

    init: function() {

       /* var url = window.location.href;
        var body = document.querySelector('body');
        var regexp = /\?Scroll=/;
        if(regexp.test(url)){
            var pix = url.split('=');
         window.scrollTo(0, pix[1]);
        }
           */
        window.addEventListener('scroll', this.getScroll.bind(this));
        this.setScroll();

        if (this.login>0) {
            var desable = document.querySelectorAll('.menu>li.desable') ;
            var itemMenu= document.querySelector('.menu>li:last-child a');
            var adUser = document.querySelector('.menu li ul li:last-child');
            for(var i=0; i<desable.length; i++) {
                desable[i].classList.remove("desable");
            }
            if(this.login == 1) {
                adUser.classList.remove("desable");
                adUser.firstElementChild.setAttribute('href','adduser.php');
            }
            itemMenu.innerHTML = 'logout';
            itemMenu.setAttribute('href','index.php?deconnect=true');
        }
        if (this.error || this.success) {
             var textError = document.querySelector('p.error') ;
             if(textError != null && textError.innerHTML.length > 50) {
                textError.style.width = '20rem';
                textError.style.marginRight = '6rem';}
            Terminator.temporyze();
        }
    },
    temporyze: function() {
        setTimeout(this.clean.bind(this), 3000);
    },
    clean: function() {
        if (this.error) {
           /* window.location.replace('login.php#scroll');
                window.location.href = 'login.php?Scroll=' + getScroll(); */
         window.location.href = this.page;
        }  else  {window.location.replace('index.php')
         }
    },
    getScroll:function() {

        if (sessionStorage['lastScroll']) {
            sessionStorage['lastScroll'] = window.pageYOffset;
        } else {
            sessionStorage['lastScroll'] = 0;
        }
    },

    setScroll:function() {
        window.scrollTo(0, sessionStorage['lastScroll']);
    }
};