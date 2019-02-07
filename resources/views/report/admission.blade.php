<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="css/app.css">
</head>

<style type="text/css">
    @page {
        size: A4;
        margin: 0;
    }

    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
            margin: 10px;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        /* ... the rest of the rules ... */
    }

    #invoice {
        margin: 20px auto;
        padding: 20px;

    }
    #invoice>div{
        display: inline;
    }


    .logo {
        width: 20%;
        border: #1d68a7 1px;
        float: left;
    }
    .headline{
        font-size: 20px;
        text-align: center;
        width: 80%;
        float: left;
    }
    .address{
        text-align: center;
        width: 80%;
        float: left;
    }
</style>
<body>
    <div id="invoice">
        <div class="logo">
            mm
        </div>
        <div class="headline">
            Clinic Name
        </div>
        <div class="logo">

        </div>
        <div class="address">
            <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque consequatur consequuntur corporis
                culpa, deserunt, dolor error explicabo fugit ipsa ipsam ipsum nobis numquam odit praesentium rerum sed
                sit unde, voluptate?
            </div>
        </div>
    </div>
</body>

</html>
