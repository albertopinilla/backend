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
         text-align: center;
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
    <table style="width:100%; align:center;">
        <caption>Contenido del mensaje</caption>
        <tr>
            <th scope="col">Referencia</th>
            <th scope="col">Nombre</th>
            <th scope="col">Categoria</th>
            <th scope="col">Fecha de creación</th>
            <th scope="col">Última actualización</th>
            <th scope="col">Stock</th>
        </tr>
        
        @foreach ($data as $value )
        <tr>
            <td>{{ $value->reference }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->category }}</td>
            <td>{{ $value->created_at }}</td>
            <td>{{ $value->updated_at }}</td>
            <td>{{ $value->stock }}</td>
        </tr>
        @endforeach
        
    </table>
</body>
</html>