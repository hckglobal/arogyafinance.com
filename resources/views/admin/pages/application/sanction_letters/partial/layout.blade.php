<html>

<head>
    <title>{{$title}}</title>
    <!-- <link rel="stylesheet" type="text/css" href="/assets/admin/dist/css/print/print.css">
    <link rel="stylesheet" type="text/css" href="/assets/admin/dist/css/print/sanction_letter.css"> -->
    <style type="text/css">
    
    body,p,td,h3{
	font-family: arial, sans-serif;
	font-size: 12px;
	margin: 0;
	margin-bottom: 2px;
}
.header{
	text-align: center;
	margin-bottom: 25px; 
}
.header img{
	height: 80px;
}
h4.date{
	text-align: right;
}
.address p{
	margin: 0;
	font-weight: bold;
	text-transform: uppercase;
}
.address{
	margin-bottom: 25px;
}
p.pin{
	margin-bottom: 25px;
}
p.content{
	margin: 0;
	margin-bottom: 25px;
}
p b{
	text-transform: uppercase;
}
.footer{
	text-align: center;
	color:#641705;
}
.footer h5{
	margin:0;
	margin-top: 50px;
	font-size: 12px;
}
.footer p{
	margin: 0;
	font-size: 10px;
	margin-bottom: 8px;
}
.content p{
	margin: 0;
	margin-bottom:8px; 
}
p.title{
	margin-bottom:25px; 

}
.table-heading td{
	padding:5px 5px;
}
    </style>

   </head>

<body>
    @include('admin.pages.application.sanction_letters.partial.header')
    @yield('styles')
    @yield('content')
    @include('admin.pages.application.sanction_letters.partial.footer')
</body>
</html>
