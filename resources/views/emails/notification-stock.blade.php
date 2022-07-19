<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         body {
         font-family: Calibri;
         }
         table {
         border-collapse: collapse;
         }
         th {
         background-color: #3498db;
         color: white;
         font-weight: bold;
         }
         td {
         border: 1px solid #ccc;
         text-align: left;
         vertical-align: top;
         font-size: 14px;
         }

         .borde{
            border: 1px solid #fff;
         }
      </style>
    </head>
<body>
    <p>El límite mínimo establecido de stock por producto ha llegado a su umbral.</p>
    <table width="640" cellspacing="0" cellpadding="0" border="0" align="center" style="width:100%;">
        <tr>
            <td>Referencia</td>
            <td>Nombre</td>
            <td>Categoria</td>
            <td>Fecha de creación</td>
            <td>Última actualización</td>
            <td>Stock</td>
        </tr>
        <tr>
        @foreach ($data as $value )
            <td>{{ $value->reference }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->category }}</td>
            <td>{{ $value->created_at }}</td>
            <td>{{ $value->updated_at }}</td>
            <td>{{ $value->stock }}</td>
        @endforeach
        </tr>
    </table>
</body>
</html>