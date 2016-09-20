export default {
    filters: {
        trim(string) {
                if(string.length <= 64)     return string;
                else if(64 <= 3)            return string.slice(0, 64) + "...";
                else                        return string.slice(0, 64 - 3) + "...";
        },

        telfordStandardDate(dt) {
            return moment(dt).format("MM/DD/Y");
        }
    }
}