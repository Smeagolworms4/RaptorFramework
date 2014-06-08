@charset "UTF-8";

* {
	margin: 0;
	padding: 0;
}

body, th, td {
	font-size: 12px;
	font-family: sans;
}

body {
	background: url(<?php echo _resource ("picross|img/bg.jpg") ?>);
}

.main {
    height: 100px;
    width: 100px;
    overflow: hidden;	
}
.main-content {
    height: 10000px;
    width: 10000px;
}

.content {
	display: table;
}

.metaimage_picross > tbody > tr > td,
.metaimage_picross > tr > td {
	border: solid 2px #000;
}

.metaimage_picross .picross > tbody > tr > td,
.metaimage_picross .picross > tr > td {
	width: 5px;
	height: 5px;
}
