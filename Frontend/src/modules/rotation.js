'use strict';

export default {
    rotate: '',
    startLogoRotation(id){
        let deg = 0;
        this.rotate = setInterval(function(){
            deg++;
            window.document.getElementById(id).style.transform = "rotate("+ deg +"deg)";
        }, 1);
    },
    stopLogoRotation(id){
        clearInterval(this.rotate);
        window.document.getElementById(id).style.transform = "rotate(0deg)";
    }
};
