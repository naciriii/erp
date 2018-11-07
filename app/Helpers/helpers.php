<?php


function encode($id):string
{
	return Hashids::encode($id);
}
function decode($id):int
{
	return Hashids::decode($id)[0];
}