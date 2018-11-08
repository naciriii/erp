<?php


function encode($id):string
{
	return Hashids::encode($id);
}
function decode($id):int
{
	return Hashids::decode($id)[0];
}

function bsNotify ($params)
{
           
            return "$.notify({
            title: \"$params[0]\",
            message:\"$params[1]\",
            icon: 'fa fa-check' 
        },{
            type: \"$params[2]\",
            placement: {
        from: 'top',
        align: 'right'
    },
    offset:150
        });";
        
}
