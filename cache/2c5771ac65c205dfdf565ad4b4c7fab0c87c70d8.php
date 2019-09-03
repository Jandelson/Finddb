<html>
<link
    rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous">
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<?php

$db = new PDO(
    "mysql:host=localhost;dbname=sogamax",
    "root",
    "admmysqlgeweb"
);

function consultaMenu($campo, $db)
{
    $campos = [
        'TABLE_SCHEMA',
        'TABLE_NAME',
        'COLUMN_NAME',
        'COLUMN_TYPE'
    ];

    $campos = implode(",", $campos);

    $stmt = $db->prepare('
        SELECT
            '.$campos.'
        FROM
            INFORMATION_SCHEMA.COLUMNS
        WHERE
            TABLE_SCHEMA = "sogamax"
            AND COLUMN_NAME like "%'.$campo.'%"
        ORDER BY
            ORDINAL_POSITION ASC
    ');

    $count = 0;
    $array = [];
    if ($stmt->execute()) {
        while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $count ++;
            $array[] = $dados;
        }
    }
    return $array;
}
$campo = 'bloque';
$array = consultaMenu($campo, $db);
//region: listar opções menu
print '<br>';
print '<div class="container table-responsive">';
/**
 * Search
 */
print "<input name='consulta' id='txt_consulta' placeholder='Consultar' type='text' class='form-control'><br>";
print '<table id=tabela  class="table table-bordered table-dark">';
print '<tbody><tr>
<th>Tabela</th>
<th>Coluna</th>
<th>Tipo</th>
<tr></tbody>
';
foreach ($array as $key => $value) {
    print '<tr>
        <td>'.$value['TABLE_NAME'].'</td>
        <td>'.$value['COLUMN_NAME'].'</td>
        <td>'.$value['COLUMN_TYPE'].'</td>
    </tr>';
}
print "Total registros: ".$count;
print '</table></div>';
?>
<script>
$(document).ready(function(){
    $("#txt_consulta").focus();
    $("#txt_consulta").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tabela tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script><?php /**PATH /opt/lampp/htdocs/findb/views/index.blade.php ENDPATH**/ ?>