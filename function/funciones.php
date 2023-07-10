<?php header('Content-Type: text/html; charset=UTF-8');

class funciones
{
    public static function buscarusuariop()
    {
        include '../conexionbd.php';
        $data = odbc_exec($conexion, "SELECT NOMBRE,CODUSUARIO FROM CONTROL_OFIMAEnterprise..MTUSUARIO ");
        while ($Element = odbc_fetch_array($data)) {
            $arr[] = $Element;
        }
        return $arr;
    }


    public static function buscarCodigo($factura)
    {
        include '../conexionbd.php';

        $data = odbc_exec($conexion, "SELECT cantidad, codigo, descripcion, Nombre_Producto_Mvto, PRODUCTO
        FROM [SIGCRUGE].[dbo].[servicio_cliente]  AS SC  
        LEFT join DUQUESA..vReporteMvFacturas MF  ON MF.NumeroDocumento COLLATE Modern_Spanish_CI_AS = SC.factura 
        LEFT join SIGCRUGE..serv_causales SUC on SC.id_causal = SUC.id 
        WHERE factura = '$factura'");
        while ($Element = odbc_fetch_array($data)) {
            $arr[] = $Element;
        }
        return $arr;
    }


    public static function buscarCliente($factura)
    {
        include '../conexionbd.php';

        $data = odbc_exec($conexion, "SELECT TOP 1 codigo, nit, nombre
        FROM [SIGCRUGE].[dbo].[servicio_cliente] AS SC
        LEFT JOIN DUQUESA..vReporteMvFacturas MF ON MF.NumeroDocumento COLLATE Modern_Spanish_CI_AS = SC.factura
        LEFT JOIN SIGCRUGE..serv_causales SUC ON SC.id_causal = SUC.id
        WHERE factura = '$factura'");
        while ($Element = odbc_fetch_array($data)) {
            $arr[] = $Element;
        }
        return $arr;
    }


    public static function filtrarDevoluciones()
    {
        include '../conexionbd.php';

        $data = odbc_exec($conexion, "SELECT DISTINCT factura, codigo, usuario, nombre, TIPODEFACTURA, notaCredito
        FROM [DUQUESA].[dbo].[DistribucionDevoluciones] where notaCredito = '0'");
        while ($Element = odbc_fetch_array($data)) {
            $arr[] = $Element;
        }
        return $arr;
    }

    public static function filtrarFactura($factura)
    {
        include '../conexionbd.php';
    
        $data = odbc_exec($conexion, "SELECT factura, codigo, fechaRecibido, fechaEnviado, usuario, nombre, TIPODEFACTURA, PRODUCTO, Nombre_Producto_Mvto, cantidad, cantidadOriginal
            FROM [DUQUESA].[dbo].[DistribucionDevoluciones] where factura = '$factura'");
        while ($Element = odbc_fetch_array($data)) {
            $arr[] = $Element;
        }
        return $arr;
    }

    public static function filtrarFacuraNotacredito($factura)
    {
        include '../conexionbd.php';

        $data = odbc_exec($conexion, "SELECT DISTINCT factura, codigo, usuario, nombre, TIPODEFACTURA, notaCredito
        FROM [DUQUESA].[dbo].[DistribucionDevoluciones] where factura = '$factura'");
        while ($Element = odbc_fetch_array($data)) {
            $arr[] = $Element;
        }
        return $arr;
    }



}