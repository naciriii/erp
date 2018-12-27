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
 * @param $htmlId : : data table id
 * @return string
 */
function dataTable($htmlId)
{
    return "$('" . $htmlId . "').DataTable({
            paginate: false,
            bInfo: false,
            searching: false,
            ordering: false
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
 * @param search : string
 * @return string
 */

function simplePagination($result, $htmlId, $findBy)
{
    if ($findBy != '') {
        $hrefTextPrefix = "hrefTextPrefix: '?search=$findBy&page=',";
    } else {
        $hrefTextPrefix = "hrefTextPrefix: '?page=',";
    }
    return "$('" . $htmlId . "').pagination({
                items: " . $result->total_count . ",
                itemsOnPage: " . $result->search_criteria->page_size . ",
                cssStyle: 'light-theme',
                " . $hrefTextPrefix . "
                currentPage: " . $result->search_criteria->current_page . ",
                listStyle: 'pagination',
            });";
}
