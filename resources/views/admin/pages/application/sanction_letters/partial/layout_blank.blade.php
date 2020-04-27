<html>

<head>
    <title>{{$title}}</title>
    <!-- <link rel="stylesheet" type="text/css" href="/assets/admin/dist/css/print/print.css">
    <link rel="stylesheet" type="text/css" href="/assets/admin/dist/css/print/sanction_letter.css"> -->
    <style type="text/css">
    body,p,td,h3{
	font-family: arial, sans-serif;
	font-size: 10px;
	margin: 0;
	margin-bottom: 2px;
}
.header{
	text-align: center;
	margin-bottom: 25px; 
}
.header img{
	height: 100px;
}

table{
	width: 100%;
}

table.compact{
	font-size: 8px;
	font-weight: bold;
}

table td{
	padding: 3px;
}

.h3.title{
	font-size: 10px;
}
.uc{
	text-transform: uppercase;
}
.tc{
	text-align: center;
}

.tj{
	text-align: justify;
}

.small{
	font-size: 8px;
}

.b{
	font-weight:bold;
}

p.signature{
	text-align: center;

}
.title{
	font-size: 12px;
}
.custom-td-width {
	width: 7%;
}
.custom-td-title {
	width: 21%;
}
p.signature img{
	margin: 10px;
}

header.letterhead{
	text-align: center;
	margin-bottom: 10px;
}

header.letterhead h3{
	font-size: 12px;
}

header.letterhead p{
	font-size: 10px;
}
    </style>

   </head>

<body>
    @yield('content')
</body>
</html>
