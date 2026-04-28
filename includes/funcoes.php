<?php 
function statusTexto($status){
switch ($status){
    case 1: return "pendentes";
    case 2: return "Em andamento";
    case 3: return "Finalizado";
    case 4: return "Cancelada";
    case 5: return "Recusada";
    default: return "Desconhecido";
}

}