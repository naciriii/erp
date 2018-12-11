<?php


function encode($id): string
{
    return Hashids::encode($id);
}

function decode($id): int
{
    return Hashids::decode($id)[0];
}

function bsNotify($params)
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

/**
 * @param $result : collection
 * {
 *  $result->total_count,
 *  $result->search_criteria->page_size,
 *  $result->search_criteria->current_page
 * }
 * @param $htmlId : html component id
 * @return string
 */

function simplePagination($result, $htmlId)
{
    return "$('" . $htmlId . "').pagination({
                items: " . $result->total_count . ",
                itemsOnPage: " . $result->search_criteria->page_size . ",
                cssStyle: 'light-theme',
                hrefTextPrefix: '?page=',
                currentPage: " . $result->search_criteria->current_page . ",
                listStyle: 'pagination',
            });";
}
