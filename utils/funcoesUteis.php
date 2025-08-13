<?php

function formatarData($data)
{
    return date('d/m/Y',$data);
}

function parseTimestamp(int $data){
    return date('d-m-Y', $data);
}

function parseISO(int $data){
    return date('Y-m-d', $data);
}

?>