/**
 * Created by agbaydan on 6/28/2017.
 */
function parse_json(json) {
    try {
        var data = $.parseJSON(json);
    } catch(err) {
        throw "JSON parse error: " + json;
    }

    return data;
}