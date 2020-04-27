@extends('admin.pages.application.sanction_letters.partial.layout_blank')
@section('content')
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- <link rel="stylesheet" href="/assets/admin/dist/css/base.min.css" />
    <link rel="stylesheet" href="/assets/admin/dist/css/fancy.min.css" />
    <link rel="stylesheet" href="/assets/admin/dist/css/main.css" /> -->
    <style type="text/css">
        

/*base.min.css*/

/*! 
 * Base CSS
 * Copyright 2012,2013 Lu Wang <coolwanglu@gmail.com> 
 * https://github.com/coolwanglu/pdf2htmlEX/blob/master/share/LICENSE
 */#sidebar{position:absolute;top:0;left:0;bottom:0;width:250px;padding:0;margin:0;overflow:auto}#page-container{position:absolute;top:0;left:0;margin:0;padding:0;border:0}@media screen{#sidebar.opened+#page-container{left:250px}#page-container{bottom:0;right:0;overflow:auto}.loading-indicator{display:none}.loading-indicator.active{display:block;position:absolute;width:64px;height:64px;top:50%;left:50%;margin-top:-32px;margin-left:-32px}.loading-indicator img{position:absolute;top:0;left:0;bottom:0;right:0}}@media print{@page{margin:0}html{margin:0}body{margin:0;-webkit-print-color-adjust:exact}#sidebar{display:none}#page-container{width:auto;height:auto;overflow:visible;background-color:transparent}.d{display:none}}.pf{position:relative;background-color:white;overflow:hidden;margin:0;border:0}.pc{position:absolute;border:0;padding:0;margin:0;top:0;left:0;width:100%;height:100%;overflow:hidden;display:block;transform-origin:0 0;-ms-transform-origin:0 0;-webkit-transform-origin:0 0}.pc.opened{display:block}.bf{position:absolute;border:0;margin:0;top:0;bottom:0;width:100%;height:100%;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;user-select:none}.bi{position:absolute;border:0;margin:0;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none;user-select:none}@media print{.pf{margin:0;box-shadow:none;page-break-after:always;page-break-inside:avoid}@-moz-document url-prefix(){.pf{overflow:visible;border:1px solid #fff}.pc{overflow:visible}}}.c{position:absolute;border:0;padding:0;margin:0;overflow:hidden;display:block}.t{position:absolute;white-space:pre;font-size:1px;transform-origin:0 100%;-ms-transform-origin:0 100%;-webkit-transform-origin:0 100%;unicode-bidi:bidi-override;-moz-font-feature-settings:"liga" 0}.t:after{content:''}.t:before{content:'';display:inline-block}.t span{position:relative;unicode-bidi:bidi-override}._{display:inline-block;color:transparent;z-index:-1}::selection{background:rgba(127,255,255,0.4)}::-moz-selection{background:rgba(127,255,255,0.4)}.pi{display:none}.d{position:absolute;transform-origin:0 100%;-ms-transform-origin:0 100%;-webkit-transform-origin:0 100%}.it{border:0;background-color:rgba(255,255,255,0.0)}.ir:hover{cursor:pointer}

/*fancy.css*/
/*! 
 * Fancy styles
 * Copyright 2012,2013 Lu Wang <coolwanglu@gmail.com> 
 * https://github.com/coolwanglu/pdf2htmlEX/blob/master/share/LICENSE
 */@keyframes fadein{from{opacity:0}to{opacity:1}}@-webkit-keyframes fadein{from{opacity:0}to{opacity:1}}@keyframes swing{0{transform:rotate(0)}10%{transform:rotate(0)}90%{transform:rotate(720deg)}100%{transform:rotate(720deg)}}@-webkit-keyframes swing{0{-webkit-transform:rotate(0)}10%{-webkit-transform:rotate(0)}90%{-webkit-transform:rotate(720deg)}100%{-webkit-transform:rotate(720deg)}}@media screen{#sidebar{background-color:#2f3236;background-image:url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjNDAzYzNmIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDBMNCA0Wk00IDBMMCA0WiIgc3Ryb2tlLXdpZHRoPSIxIiBzdHJva2U9IiMxZTI5MmQiPjwvcGF0aD4KPC9zdmc+")}#outline{font-family:Georgia,Times,"Times New Roman",serif;font-size:13px;margin:2em 1em}#outline ul{padding:0}#outline li{list-style-type:none;margin:1em 0}#outline li>ul{margin-left:1em}#outline a,#outline a:visited,#outline a:hover,#outline a:active{line-height:1.2;color:#e8e8e8;text-overflow:ellipsis;white-space:nowrap;text-decoration:none;display:block;overflow:hidden;outline:0}#outline a:hover{color:#0cf}#page-container{background-color:#9e9e9e;background-image:url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjOWU5ZTllIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDVMNSAwWk02IDRMNCA2Wk0tMSAxTDEgLTFaIiBzdHJva2U9IiM4ODgiIHN0cm9rZS13aWR0aD0iMSI+PC9wYXRoPgo8L3N2Zz4=");-webkit-transition:left 500ms;transition:left 500ms}.pf{margin:13px auto;box-shadow:1px 1px 3px 1px #333;border-collapse:separate}.pc.opened{-webkit-animation:fadein 100ms;animation:fadein 100ms}.loading-indicator.active{-webkit-animation:swing 1.5s ease-in-out .01s infinite alternate none;animation:swing 1.5s ease-in-out .01s infinite alternate none}.checked{background:no-repeat url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3goQDSYgDiGofgAAAslJREFUOMvtlM9LFGEYx7/vvOPM6ywuuyPFihWFBUsdNnA6KLIh+QPx4KWExULdHQ/9A9EfUodYmATDYg/iRewQzklFWxcEBcGgEplDkDtI6sw4PzrIbrOuedBb9MALD7zv+3m+z4/3Bf7bZS2bzQIAcrmcMDExcTeXy10DAFVVAQDksgFUVZ1ljD3yfd+0LOuFpmnvVVW9GHhkZAQcxwkNDQ2FSCQyRMgJxnVdy7KstKZpn7nwha6urqqfTqfPBAJAuVymlNLXoigOhfd5nmeiKL5TVTV+lmIKwAOA7u5u6Lped2BsbOwjY6yf4zgQQkAIAcedaPR9H67r3uYBQFEUFItFtLe332lpaVkUBOHK3t5eRtf1DwAwODiIubk5DA8PM8bYW1EU+wEgCIJqsCAIQAiB7/u253k2BQDDMJBKpa4mEon5eDx+UxAESJL0uK2t7XosFlvSdf0QAEmlUnlRFJ9Waho2Qghc1/U9z3uWz+eX+Wr+lL6SZfleEAQIggA8z6OpqSknimIvYyybSCReMsZ6TislhCAIAti2Dc/zejVNWwCAavN8339j27YbTg0AGGM3WltbP4WhlRWq6Q/btrs1TVsYHx+vNgqKoqBUKn2NRqPFxsbGJzzP05puUlpt0ukyOI6z7zjOwNTU1OLo6CgmJyf/gA3DgKIoWF1d/cIY24/FYgOU0pp0z/Ityzo8Pj5OTk9PbwHA+vp6zWghDC+VSiuRSOQgGo32UErJ38CO42wdHR09LBQK3zKZDDY2NupmFmF4R0cHVlZWlmRZ/iVJUn9FeWWcCCE4ODjYtG27Z2Zm5juAOmgdGAB2d3cBADs7O8uSJN2SZfl+WKlpmpumaT6Yn58vn/fs6XmbhmHMNjc3tzDGFI7jYJrm5vb29sDa2trPC/9aiqJUy5pOp4f6+vqeJ5PJBAB0dnZe/t8NBajx/z37Df5OGX8d13xzAAAAAElFTkSuQmCC)}}



 /*main.css*/
        .ff0{font-family:sans-serif;visibility:hidden;}
@font-face{font-family:ff1;src:url(f1.woff)format("woff");}.ff1{font-family:ff1;line-height:0.904000;font-style:normal;font-weight:normal;visibility:visible;}
@font-face{font-family:ff2;src:url(f2.woff)format("woff");}.ff2{font-family:ff2;line-height:0.896000;font-style:normal;font-weight:normal;visibility:visible;}
@font-face{font-family:ff3;src:url(f3.woff)format("woff");}.ff3{font-family:ff3;line-height:0.741000;font-style:normal;font-weight:normal;visibility:visible;}
@font-face{font-family:ff4;src:url(f4.woff)format("woff");}.ff4{font-family:ff4;line-height:0.740000;font-style:normal;font-weight:normal;visibility:visible;}
.m1{transform:matrix(0.234142,0.000000,0.000000,0.250000,0,0);-ms-transform:matrix(0.234142,0.000000,0.000000,0.250000,0,0);-webkit-transform:matrix(0.234142,0.000000,0.000000,0.250000,0,0);}
.m3{transform:matrix(0.240660,0.000000,0.000000,0.250000,0,0);-ms-transform:matrix(0.240660,0.000000,0.000000,0.250000,0,0);-webkit-transform:matrix(0.240660,0.000000,0.000000,0.250000,0,0);}
.m2{transform:matrix(0.242054,0.000000,0.000000,0.250000,0,0);-ms-transform:matrix(0.242054,0.000000,0.000000,0.250000,0,0);-webkit-transform:matrix(0.242054,0.000000,0.000000,0.250000,0,0);}
.m0{transform:matrix(0.250000,0.000000,0.000000,0.250000,0,0);-ms-transform:matrix(0.250000,0.000000,0.000000,0.250000,0,0);-webkit-transform:matrix(0.250000,0.000000,0.000000,0.250000,0,0);}
.v0{vertical-align:0.000000px;}
.ls0{letter-spacing:0.000000px;}
.sc_{text-shadow:none;}
.sc0{text-shadow:-0.015em 0 transparent,0 0.015em transparent,0.015em 0 transparent,0 -0.015em  transparent;}
@media screen and (-webkit-min-device-pixel-ratio:0){
.sc_{-webkit-text-stroke:0px transparent;}
.sc0{-webkit-text-stroke:0.015em transparent;text-shadow:none;}
}
.ws0{word-spacing:0.000000px;}
._3{margin-left:-2.384762px;}
._0{margin-left:-1.113163px;}
._8{width:14.310441px;}
._6{width:20.471205px;}
._7{width:23.148707px;}
._5{width:27.987443px;}
._1{width:29.082437px;}
._b{width:30.690546px;}
._a{width:41.370735px;}
._9{width:51.566141px;}
._2{width:65.352980px;}
._4{width:74.398359px;}
.fc1{color:rgb(35,31,32);}
.fc0{color:rgb(233,233,233);}
.fs6{font-size:15.999574px;}
.fs5{font-size:16.012054px;}
.fs7{font-size:24.600881px;}
.fs1{font-size:31.966309px;}
.fs0{font-size:35.782783px;}
.fs2{font-size:39.599297px;}
.fs3{font-size:39.759176px;}
.fs4{font-size:65.314695px;}
.y0{bottom:156.500000px;}
.y36{bottom:159.740306px;}
.y35{bottom:163.998430px;}
.y34{bottom:169.021552px;}
.y33{bottom:173.279675px;}
.y28{bottom:179.605665px;}
.y6{bottom:179.963664px;}
.y3{bottom:180.201664px;}
.y8{bottom:182.111061px;}
.y5{bottom:182.231060px;}
.y2{bottom:182.469060px;}
.y2e{bottom:184.929276px;}
.y2d{bottom:186.138654px;}
.y30{bottom:201.098880px;}
.y2f{bottom:201.147630px;}
.y7{bottom:201.196630px;}
.y4{bottom:201.316630px;}
.y1{bottom:201.554630px;}
.y2c{bottom:203.673626px;}
.y2b{bottom:220.566599px;}
.y2a{bottom:222.878695px;}
.y29{bottom:236.596173px;}
.y37{bottom:246.154558px;}
.y14{bottom:256.671541px;}
.y1f{bottom:257.506340px;}
.y1e{bottom:275.161312px;}
.y13{bottom:275.995310px;}
.y1b{bottom:292.677484px;}
.y18{bottom:293.393858px;}
.y17{bottom:293.585107px;}
.y19{bottom:293.631482px;}
.y1a{bottom:293.704607px;}
.y16{bottom:294.224481px;}
.y15{bottom:294.347781px;}
.y11{bottom:308.873458px;}
.y12{bottom:326.999029px;}
.yf{bottom:326.999229px;}
.y10{bottom:328.788426px;}
.y21{bottom:329.384325px;}
.y20{bottom:329.504325px;}
.y25{bottom:345.535799px;}
.ye{bottom:347.162997px;}
.y24{bottom:356.842081px;}
.yb{bottom:363.214371px;}
.yd{bottom:364.407369px;}
.y26{bottom:367.174365px;}
.yc{bottom:367.388364px;}
.y23{bottom:368.148363px;}
.y22{bottom:379.851344px;}
.y1c{bottom:381.578641px;}
.y1d{bottom:382.771140px;}
.y38{bottom:385.238336px;}
.y32{bottom:393.492322px;}
.ya{bottom:399.332563px;}
.y27{bottom:402.589308px;}
.y9{bottom:403.626306px;}
.y31{bottom:426.565269px;}
.h8{height:11.487694px;}
.h7{height:11.656776px;}
.h9{height:17.663432px;}
.h3{height:22.951810px;}
.ha{height:25.692038px;}
.h2{height:25.978300px;}
.h4{height:28.432295px;}
.h5{height:28.944680px;}
.h6{height:47.549098px;}
.h1{height:264.000000px;}
.h0{height:595.000000px;}
.w1{width:596.000000px;}
.w0{width:842.000000px;}
.x0{left:123.000000px;}
.xf{left:155.822351px;}
.x11{left:157.013749px;}
.x27{left:159.440745px;}
.x22{left:162.381740px;}
.x23{left:189.777696px;}
.xb{left:196.377686px;}
.x24{left:205.443771px;}
.xe{left:216.776653px;}
.x13{left:220.235648px;}
.x25{left:222.140145px;}
.x19{left:240.035616px;}
.x10{left:256.973589px;}
.x9{left:265.681575px;}
.x14{left:295.383627px;}
.x15{left:301.586117px;}
.x21{left:316.287494px;}
.x1{left:321.893485px;}
.x26{left:334.364465px;}
.xc{left:338.354459px;}
.x2{left:339.666557px;}
.x28{left:359.875424px;}
.x12{left:400.024360px;}
.x3{left:447.378284px;}
.x1a{left:461.574261px;}
.x4{left:463.124259px;}
.x5{left:470.162998px;}
.x18{left:490.580215px;}
.x1b{left:502.031097px;}
.x1c{left:503.939844px;}
.xd{left:520.520167px;}
.x16{left:546.046126px;}
.x1e{left:563.705398px;}
.x1d{left:573.481632px;}
.x6{left:583.977066px;}
.x1f{left:587.221060px;}
.xa{left:591.970053px;}
.x7{left:599.723040px;}
.x8{left:606.641779px;}
.x20{left:616.540014px;}
.x17{left:631.572189px;}
@media print{
.v0{vertical-align:0.000000pt;}
.ls0{letter-spacing:0.000000pt;}
.ws0{word-spacing:0.000000pt;}
._3{margin-left:-3.179682pt;}
._0{margin-left:-1.484217pt;}
._8{width:19.080588pt;}
._6{width:27.294940pt;}
._7{width:30.864943pt;}
._5{width:37.316590pt;}
._1{width:38.776583pt;}
._b{width:40.920727pt;}
._a{width:55.160980pt;}
._9{width:68.754855pt;}
._2{width:87.137307pt;}
._4{width:99.197813pt;}
.fs6{font-size:21.332766pt;}
.fs5{font-size:21.349406pt;}
.fs7{font-size:32.801174pt;}
.fs1{font-size:42.621745pt;}
.fs0{font-size:47.710377pt;}
.fs2{font-size:52.799062pt;}
.fs3{font-size:53.012235pt;}
.fs4{font-size:87.086261pt;}
.y0{bottom:208.666667pt;}
.y36{bottom:212.987075pt;}
.y35{bottom:218.664573pt;}
.y34{bottom:225.362069pt;}
.y33{bottom:231.039566pt;}
.y28{bottom:239.474220pt;}
.y6{bottom:239.951552pt;}
.y3{bottom:240.268885pt;}
.y8{bottom:242.814747pt;}
.y5{bottom:242.974747pt;}
.y2{bottom:243.292080pt;}
.y2e{bottom:246.572368pt;}
.y2d{bottom:248.184872pt;}
.y30{bottom:268.131840pt;}
.y2f{bottom:268.196840pt;}
.y7{bottom:268.262173pt;}
.y4{bottom:268.422173pt;}
.y1{bottom:268.739506pt;}
.y2c{bottom:271.564835pt;}
.y2b{bottom:294.088799pt;}
.y2a{bottom:297.171594pt;}
.y29{bottom:315.461565pt;}
.y37{bottom:328.206078pt;}
.y14{bottom:342.228722pt;}
.y1f{bottom:343.341787pt;}
.y1e{bottom:366.881749pt;}
.y13{bottom:367.993747pt;}
.y1b{bottom:390.236645pt;}
.y18{bottom:391.191810pt;}
.y17{bottom:391.446810pt;}
.y19{bottom:391.508643pt;}
.y1a{bottom:391.606143pt;}
.y16{bottom:392.299308pt;}
.y15{bottom:392.463708pt;}
.y11{bottom:411.831277pt;}
.y12{bottom:435.998705pt;}
.yf{bottom:435.998972pt;}
.y10{bottom:438.384568pt;}
.y21{bottom:439.179100pt;}
.y20{bottom:439.339100pt;}
.y25{bottom:460.714399pt;}
.ye{bottom:462.883995pt;}
.y24{bottom:475.789441pt;}
.yb{bottom:484.285828pt;}
.yd{bottom:485.876492pt;}
.y26{bottom:489.565819pt;}
.yc{bottom:489.851152pt;}
.y23{bottom:490.864484pt;}
.y22{bottom:506.468459pt;}
.y1c{bottom:508.771522pt;}
.y1d{bottom:510.361519pt;}
.y38{bottom:513.651114pt;}
.y32{bottom:524.656430pt;}
.ya{bottom:532.443417pt;}
.y27{bottom:536.785744pt;}
.y9{bottom:538.168408pt;}
.y31{bottom:568.753693pt;}
.h8{height:15.316926pt;}
.h7{height:15.542367pt;}
.h9{height:23.551243pt;}
.h3{height:30.602413pt;}
.ha{height:34.256051pt;}
.h2{height:34.637734pt;}
.h4{height:37.909727pt;}
.h5{height:38.592907pt;}
.h6{height:63.398798pt;}
.h1{height:352.000000pt;}
.h0{height:793.333333pt;}
.w1{width:794.666667pt;}
.w0{width:1122.666667pt;}
.x0{left:164.000000pt;}
.xf{left:207.763134pt;}
.x11{left:209.351665pt;}
.x27{left:212.587660pt;}
.x22{left:216.508987pt;}
.x23{left:253.036928pt;}
.xb{left:261.836914pt;}
.x24{left:273.925028pt;}
.xe{left:289.035538pt;}
.x13{left:293.647530pt;}
.x25{left:296.186859pt;}
.x19{left:320.047488pt;}
.x10{left:342.631452pt;}
.x9{left:354.242100pt;}
.x14{left:393.844837pt;}
.x15{left:402.114823pt;}
.x21{left:421.716659pt;}
.x1{left:429.191313pt;}
.x26{left:445.819287pt;}
.xc{left:451.139278pt;}
.x2{left:452.888742pt;}
.x28{left:479.833899pt;}
.x12{left:533.365813pt;}
.x3{left:596.504379pt;}
.x1a{left:615.432349pt;}
.x4{left:617.499012pt;}
.x5{left:626.883997pt;}
.x18{left:654.106953pt;}
.x1b{left:669.374796pt;}
.x1c{left:671.919792pt;}
.xd{left:694.026890pt;}
.x16{left:728.061502pt;}
.x1e{left:751.607197pt;}
.x1d{left:764.642177pt;}
.x6{left:778.636088pt;}
.x1f{left:782.961414pt;}
.xa{left:789.293404pt;}
.x7{left:799.630721pt;}
.x8{left:808.855706pt;}
.x20{left:822.053351pt;}
.x17{left:842.096253pt;}
}
.x0{
    left:52px!important;
}
.w1 {
    width: 745px;
}
.h1 {
    height: 276px;
}
.x9 {
    left: 237.681575px;
}
.h2 {
        height: 64.9783px;
}
.h2 {
    height: 81.9783px;
}
.xa {
    left: 644.970053px;
}
.h2 {
    height: 67.9783px;
}
.xf {
    left: 90.822351px;
}
.x11 {
    left: 94.013749px;
}
.h7 {
    height: 53.656776px;
}
.xb {
    left: 145.377686px;
}
.x19 {
    left: 211.035616px;
}
.ha {
    height: 64.692038px;
}
.x28 {
    left: 353.875424px;
}

.x1a {
    left: 478.574261px;
}
.xe {
    left: 158.776653px;
}
.fc0 {
    color: #000;
}
.y27 {
    bottom: 413.589308px;
}
.x20 {
    left: 670.540014px;
}
.h5 {
    height: 28.944680px;
}
.yc {
    bottom: 370.388364px;
}
.h3 {
    height: 49.95181px;
}
.x1f {
    left: 634.22106px;
}
.xd {
    left: 557.520167px;
}
.x1d {
    left: 615.481632px;
}
.x1e {
    left: 603.705398px;
}
.x13 {
    left: 179.235648px;
}
.y16 {
    bottom: 300.224481px;
}
.x15 {
    left: 303.586117px;
}
.y18 {
    bottom: 300.393858px;
}
.x14 {
    left: 270.383627px;
}
.y17 {
    bottom: 300.585107px;
}
.x15 {
    left: 278.586117px;
}
.xc {
    left: 326.354459px;
}
.x18 {
    left: 508.580215px;
}
.y1b {
    bottom: 289.677484px;
}
.x16 {
    left: 582.046126px;
}
.y19 {
    bottom: 299.631482px;
}
.x17 {
    left: 681.572189px;
}
.y1a {
    bottom: 299.704607px;
}
.x1b {
    left: 530.031097px;
}
.y1e {
    bottom: 271.161312px;
}
.x1c {
    left: 533.939844px;
}
.y1f {
    bottom: 250.50634px;
}
.x27 {
    left: 97.440745px;
}
.h9 {
    height: 32.663432px;
}
.x22 {
    left: 102.38174px;
}
.y29 {
    bottom: 229.596173px;
}
.y2a {
    bottom: 214.878695px;
}
.y2c {
    bottom: 194.673626px;
}
.y2d {
    bottom: 177.138654px;
}
.x23 {
    left: 135.777696px;
}
.y2b {
    bottom: 225.566599px;
}
.fs3 {
    font-size: 56.759176px;
}
.x25 {
    left: 174.140145px;
}
.y30 {
    bottom: 204.09888px;
}
.y2f {
    bottom: 204.14763px;
}
.x24 {
    left: 157.443771px;
}
.y2e {
    bottom: 176.929276px;
}
.y1 {
    bottom: 200.55463px;
}
.x1 {
    left: 315.893485px;
}
.x2 {
    left: 309.666557px;
}
.y2 {
    bottom: 173.46906px;
}
.x4 {
    left: 489.124259px;
}
.y4 {
    bottom: 200.55463px;
}
.x7 {
    left: 658.72304px;
}
.y7 {
    bottom: 200.55463px;
}
.y28 {
    bottom: 171.605665px;
}
.x3 {
    left: 462.378284px;
}
.y3 {
    bottom: 171.201664px;
}
.x5 {
    left: 471.162998px;
}
.y5 {
    bottom: 174.23106px;
}
.x6 {
    left: 632.977066px;
}
.y6 {
    bottom: 170.963664px;
}
.x8 {
    left: 642.641779px;
}
.y8 {
    bottom: 174.111061px;
}
.y27 {
    bottom: 415.589308px;
}
.fs3 {
    font-size: 52.759176px;
}
.fs7 {
    font-size: 25.600881px;
}
.x21 {
    left: 299.287494px;
}
.xf {
    left: 95.822351px;
}
.xd {
    left: 562.520167px;
}
.xb {
    left: 155.377686px;
}
.xe {
    left: 173.776653px;
}
.fs0 {
    font-size: 35.782783px;
}
.y15 {
    bottom: 290.347781px;
}
.bank{
    top: 215px;
    left: 147px;
}
.amntwd{
    top: 235px;
    left: 205px !important;
}
.amnt{
    top: 236px;
    left: 679px !important;
}
    
.fs3 {
    font-size: 52.759176px;
    letter-spacing: 36px;
}
.y27 {
    bottom: 414.589308px;
}
.x10 {
    left: 148.973589px;
}
.ref1 {
    top: 270px;
    left: 157px;
}
.ref2 {
    top: 290px;
    left: 157px;
}
.phn {
    top: 270px;
    left: 581px;
}
.email {
    top: 289px;
    left: 581px;
}
.validfrom {
    top: 340px;
    letter-spacing: 51px !important;
}
.validupto {
    top: 362px;
    letter-spacing: 51px;
}

    </style>
    <script src="/assets/admin/dist/js/compatibility.min.js"></script>
    <script src="/assets/admin/dist/js/theViewer.min.js"></script>
    <script>
        try {
            theViewer.defaultViewer = new theViewer.Viewer({});
        } catch (e) {}
    </script>
    <title></title>
</head>
<body>
    <div id="sidebar">
        <div id="outline">
        </div>
    </div>
    <div id="page-container">
        <div id="pf1" class="pf w0 h0" data-page-no="1">
            <div class="pc pc1 w0 h0"><img class="bi x0 y0 w1 h1" alt="" src="/assets/images/bg1.png" />
                <div class="t m0 x2 h2 y2 ff1 fs0 fc0 sc0 ls0 ws0">Name as in bank records</div>
                <div class="t m0 x3 h2 y3 ff1 fs0 fc1 sc0 ls0 ws0">2.</div>
                <div class="t m0 x5 h2 y5 ff1 fs0 fc0 sc0 ls0 ws0">Name as in bank records</div>
                <div class="t m0 x6 h2 y6 ff1 fs0 fc1 sc0 ls0 ws0">3.</div>
                <div class="t m0 x8 h2 y8 ff1 fs0 fc0 sc0 ls0 ws0">Name as in bank records</div>
                <div class="t m0 x9 h2 y9 ff1 fs0 fc1 sc0 ls0 ws0">UMRN</div>
                <div class="t m0 xa h2 ya ff1 fs0 fc1 sc0 ls0 ws0">Date</div>
                <div class="t m0 xb h2 yb ff1 fs0 fc1 sc0 ls0 ws0">I/We hereby authorize</div>
                <div class="t m0 xc h3 yc ff2 fs1 fc0 sc0 ls0 ws0">RAMTIRTH LEASING AND FINANCE CO.PVT.LTD</div>
                <div class="t m0 xd h2 yd ff1 fs0 fc1 sc0 ls0 ws0">to debit (tick<span class="_ _1"> </span>)</div>
                <div class="t m0 xe h2 ye ff1 fs0 fc1 sc0 ls0 ws0">Bank a/c number</div>
                <div class="t m0 xf h2 yf ff1 fs0 fc1 sc0 ls0 ws0">with Bank</div>
                <div class="t m0 x10 h3 y10 ff2 fs1 fc0 sc0 ls0 bank">{{$application->repaymentCheques->first()->bank_name}}</div>
                <div class="t m0 x11 h2 y11 ff1 fs0 fc1 sc0 ls0 ws0">an amount of Rupees</div>
                <div class="t m0 x10 h3 y10 ff2 fs1 fc0 sc0 ls0 amntwd">{{App\Helpers\Helpers::getIndianCurrency($borrower->application->approved_loan_emi).' Only.'}}</div>
                <div class="t m0 x10 h3 y10 ff2 fs1 fc0 sc0 ls0 amnt">{{$borrower->application->approved_loan_emi}}</div>
                <div class="t m0 x12 h2 y12 ff1 fs0 fc1 sc0 ls0 ws0">IFSC</div>
                <div class="t m0 xf h2 y13 ff1 fs0 fc1 sc0 ls0 ws0">Reference 1</div>
                <div class="t m0 x10 h3 y10 ff2 fs1 fc0 sc0 ls0 ref1">{{$application->pin_number}}</div>
                <div class="t m0 xf h2 y14 ff1 fs0 fc1 sc0 ls0 ws0">Reference 2</div>
                <div class="t m0 x10 h3 y10 ff2 fs1 fc0 sc0 ls0 ref2">{{$application->borrower->first_name}} {{$application->borrower->middle_name}} {{$application->borrower->last_name}}</div>
                <div class="t m0 xf h2 y15 ff1 fs0 fc1 sc0 ls0 ws0">FREQUENCY</div>
                <div class="t m0 x13 h4 y16 ff2 fs2 fc1 sc0 ls0 ws0">Mthly<span class="_ _2"> </span>Qtly</div>
                <div class="t m0 x14 h4 y17 ff2 fs2 fc1 sc0 ls0 ws0">H</div>
                <div class="t m0 x15 h4 y18 ff2 fs2 fc1 sc0 ls0 ws0">-Yrly</div>
                <div class="t m0 xc h4 y16 ff2 fs2 fc1 sc0 ls0 ws0">Yrly<span class="_ _4"> </span>As &amp; when presented</div>
                <div class="t m0 x16 h4 y19 ff2 fs2 fc1 sc0 ls0 ws0">Fixed Amount</div>
                <div class="t m0 x17 h4 y1a ff2 fs2 fc1 sc0 ls0 ws0">Maximum Amount</div>
                <div class="t m0 x18 h2 y1b ff1 fs0 fc1 sc0 ls0 ws0">DEBIT TYPE</div>
                <div class="t m0 x19 h2 y1c ff1 fs0 fc1 sc0 ls0 ws0">Sponsor Bank Code</div>
                <div class="t m0 x1a h2 y1d ff1 fs0 fc1 sc0 ls0 ws0">Utility Code</div>
                <div class="t m0 x1b h2 y1e ff1 fs0 fc1 sc0 ls0 ws0">Phone No.</div>
                <div class="t m0 x10 h3 y10 ff2 fs1 fc0 sc0 ls0 phn">{{$application->borrower->mobile_number}}</div>
                <div class="t m0 x1c h2 y1f ff1 fs0 fc1 sc0 ls0 ws0">Email ID</div>
                <div class="t m0 x10 h3 y10 ff2 fs1 fc0 sc0 ls0 email">{{$application->borrower->email}}</div>
                <div class="t m0 x1d h2 y20 ff1 fs0 fc1 sc0 ls0 ws0">MICR</div>
                <div class="t m0 x1e h2 y21 ff1 fs0 fc1 sc0 ls0 ws0">or</div>
                <div class="t m0 xf h2 y22 ff1 fs0 fc1 sc0 ls0 ws0">Tick (<span class="_ _5"> </span>)</div>
                <div class="t m0 x11 h2 y23 ff1 fs0 fc1 sc0 ls0 ws0">CREATE</div>
                <div class="t m0 x11 h2 y24 ff1 fs0 fc1 sc0 ls0 ws0">MODIFY</div>
                <div class="t m0 x11 h2 y25 ff1 fs0 fc1 sc0 ls0 ws0">CANCEL</div>
                <div class="t m1 x1f h2 y26 ff1 fs0 fc1 sc0 ls0 ws0">SB/CA/CC/SB-NRE / SB-NRO /Other</div>
                <div class="t m0 x20 h5 y27 ff3 fs3 fc0 sc0 ls0 ws0">{{Carbon\Carbon::now()->format('dmY')}}</div>
                <div class="t m0 x21 h2 y28 ff1 fs0 fc1 sc0 ls0 ws0">1.</div>
                <div class="t m0 x22 h2 y29 ff1 fs0 fc1 sc0 ls0 ws0">PERIOD</div>
                <div class="t m0 x22 h2 y2a ff1 fs0 fc1 sc0 ls0 ws0">From</div>
                <div class="t m0 x23 h5 y2b ff3 fs3 fc0 sc0 ls0 validfrom">{{Carbon\Carbon::parse($application->valid_from)->format('dmY')}}</div>
                <div class="t m0 x22 h2 y2c ff1 fs0 fc1 sc0 ls0 ws0">To</div>
                <div class="t m0 x23 h5 y2b ff3 fs3 fc0 sc0 ls0 validupto">{{Carbon\Carbon::parse($application->valid_upto)->format('dmY')}}</div>
                <div class="t m0 x22 h2 y2d ff1 fs0 fc1 sc0 ls0 ws0">Or</div>
                <div class="t m0 x24 h2 y2e ff1 fs0 fc1 sc0 ls0 ws0">Until Cancelled</div>
                <div class="t m2 xb h7 y32 ff4 fs5 fc1 sc0 ls0 ws0">HDFC BANK LIMITED.</div>
                <div class="t m3 x27 h8 y33 ff2 fs6 fc1 sc0 ls0 ws0">• This is to confirm that the declaration has been carefully read,understood and made by me/us.I am authorising the user entity/corporate to debit my account.</div>
                <div class="t m3 x27 h8 y34 ff2 fs6 fc1 sc0 ls0 ws0">• I have understood that I am authorised to cancel/amend this mandate by appropriately communicating the cancellation/amendment request to the user entity/corporate or the bank where i have authorized the debit.</div>
                <div class="t m3 x27 h8 y35 ff2 fs6 fc1 sc0 ls0 ws0">I/We hereby declare that the above information is true and correct and that the mobile number listed above is registered in my/our name(s) and/or is the number that I/we use in the ordinary course. I/We hereby declare that, irrespective of my/our registration of the above mobile in the provider customer preference register, or in any similar register</div>
                <div class="t m3 x27 h8 y36 ff2 fs6 fc1 sc0 ls0 ws0">maintained under applicable laws, now or subsequent to the date hereof, I/We consent to the Bank communicating to me/us about the transactions carried out in my/our aforesaid account(s).</div>
                <div class="t m3 x27 h9 y37 ff2 fs7 fc1 sc0 ls0 ws0">I agree for the debit of Mandate processing charges by the Bank whom I am authorizing to debit my account as per latest Schedule of charges of the Bank.</div>
                <div class="t m0 x28 ha y38 ff2 fs0 fc1 sc0 ls0 ws0">HDFC0000060</div>
            </div>
            <div class="pi" data-data='{"ctm":[0.000000,-1.000000,1.000000,0.000000,0.000000,595.000000]}'></div>
        </div>
    </div>
    <div class="loading-indicator">

    </div>
</body>

</html>
@endsection