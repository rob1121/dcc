const telfordStandardDate = function(dt) {
    return moment(dt).format("MM/DD/Y");
};

export {
    telfordStandardDate
}