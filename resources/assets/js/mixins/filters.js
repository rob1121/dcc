import moment from "moment";

export function trim(string) {
    if(string.length <= 64)     return string;
    else if(64 <= 3)            return string.slice(0, 64) + "...";
    else                        return string.slice(0, 64 - 3) + "...";
}

export function telfordStandardDate(dt) {
    return moment(dt).format("MM/DD/Y");
}

export function latestRevision(revArray, column) {
    return typeof revArray[revArray.length-1][column] !== undefined
        ? revArray[revArray.length-1][column]
        : "N/A";
}

export function internalRoute(id) {
    return laroute.route('internal.show', {internal: id});
}

export function externalRoute(id) {
    return laroute.route('external.show', {external: id});
}

export function isNewRevision(revision_date) {
    var revision_date = moment(revision_date);
    return revision_date > moment().subtract(7, "days");
}

export function count(obj) {
    return _.size(obj);
}

export function capitalize(string) {
    return _.capitalize(string);
}

export function capitalize(string) {
    return _.toUpper(string);
}