html, body {
    margin:0;
    height:100%;
    min-height:100%;
}
body {
    display: flex;
    flex-direction: column;
}
header {
    border-bottom:2px solid #000;
    background: rgb(25,25,25);
    background: linear-gradient(107deg, rgba(25,25,25,1) 0%, rgba(0,0,0,1) 84%, rgba(25,25,25,1) 100%); }
header,
footer {
    flex:none;
}
main {
    overflow-y:scroll;
    -webkit-overflow-scrolling:touch;
    flex:auto;
    padding-top:60px;
}


/** HEADER **/
.navbar-brand {
    font-size: 24px;
    background: -webkit-linear-gradient(#eee, #ddd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    /*text-shadow: 1px 1px 0px #FFFFFF;*/
    /*-moz-text-shadow: 1px 1px 0px #FFFFFF;*/
    /*-webkit-text-shadow: 1px 1px 0px #FFFFFF;*/
}

.nav-link {
    border-radius:2px;
}
.nav-link:hover {
    background: rgb(145,7,7);
    background: linear-gradient(0deg, rgba(145,7,7,1) 41%, rgba(231,0,0,1) 100%);
}

/** MAIN: **/
main {
    background: rgb(0,0,0);
    background: linear-gradient(0deg, rgba(0,0,0,0.25) 0%, rgba(195,195,195,1) 44%, rgba(255,255,255,1) 100%);
}
main > .container {
    /*padding: 60px 15px 0;*/
}

/** FORMS: **/




.button {
    border-radius: 4px;
    background-color: #0d6efd;
    color: #FFFFFF;
    width: 200px;
    transition: all 0.5s;
    cursor: pointer;
}

.button span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
}

.button span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
}

.button:hover span {
    padding-right: 25px;
}

.button:hover span:after {
    opacity: 1;
    right: 0;
}

/** FORMS: **/
.form-control {
    text-shadow: 0px 1px 0px #fff;
    outline:0px !important;
    /*background-image: linear-gradient(bottom, #FFFFFF 5%, #DEDEDE 100%);*/
    /*background-image: -o-linear-gradient(bottom, #FFFFFF 5%, #DEDEDE 100%);*/
    /*background-image: -moz-linear-gradient(bottom, #FFFFFF 5%, #DEDEDE 100%);*/
    /*background-image: -webkit-linear-gradient(bottom, #FFFFFF 5%, #DEDEDE 100%);*/
    /*background-image: -ms-linear-gradient(bottom, #FFFFFF 5%, #DEDEDE 100%);*/
    border: 1px solid #b6b6b6;
    /*background-image: -webkit-gradient(*/
    /*        linear,*/
    /*        left bottom,*/
    /*        left top,*/
    /*        color-stop(0.05, #FFFFFF),*/
    /*        color-stop(1, #DEDEDE)*/
    /*);*/
}


.form-control:hover,
.form-control:active,
.form-control:focus {
    border-color:#333;
    outline:0px !important;
    -webkit-box-shadow:0 0 6px #000;
    -moz-box-shadow:0 0 5px #000;
    box-shadow: inset 0 0 1em #efefef, 0 0 1em #dedede;
}

hr.divider {
    border-top: 1px solid #333333;
    border-bottom: 1px solid #ffffff;
}

body .form-control:focus{
    outline: none;
}

#form-filter,
.background-white,
.list-item {
    background: rgba(255,255,255,0.8);
    border:1px solid #bbb;
    border-radius: 3px;
    -webkit-box-shadow: 0px 0px 20px 0px rgba(66, 68, 90, 0.2);
    -moz-box-shadow: 0px 0px 20px 0px rgba(66, 68, 90, 0.2);
    box-shadow: 0px 0px 20px 0px rgba(66, 68, 90, 0.2);
}
#form-filter {
    background-color:rgba(255,255,255,.9)
}
#form-filter,
.list-item {
    animation: fadeIn 0.5s;
    -webkit-animation: fadeIn 0.5s;
    -moz-animation: fadeIn 0.5s;
    -o-animation: fadeIn 0.5s;
    -ms-animation: fadeIn 0.5s;
}

/** COMMMON **/
.border-bottom-dotted {
    border-bottom:1px dotted #555555;
}

.animated-gradient {
    animation: animateBg 14s linear infinite;
    background-image: linear-gradient(90deg,#fff,#efefef,#fff,#efefef);
    background-size: 300% 100%;
}
@keyframes animateBg {
    0% { background-position: 0% 0%; }
    100% { background-position: 100% 0%; }
}

@keyframes fadeIn {
    0% {opacity:0;}
    100% {opacity:1;}
}
@-moz-keyframes fadeIn {
    0% {opacity:0;}
    100% {opacity:1;}
}
@-webkit-keyframes fadeIn {
    0% {opacity:0;}
    100% {opacity:1;}
}
@-o-keyframes fadeIn {
    0% {opacity:0;}
    100% {opacity:1;}
}
@-ms-keyframes fadeIn {
    0% {opacity:0;}
    100% {opacity:1;}
}

.row.col-wrapper-equal-height {
    display: table;
}

.row.col-wrapper-equal-height [class*="col-"] {
    float: none;
    display: table-cell;
    vertical-align: top;
}

. form-wrapper {

}