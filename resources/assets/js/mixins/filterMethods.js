export default {
	methods: {
		uppercase(string) {
		    return _.toUpper(string);
		},

		capitalize(string) {
		    return _.capitalize(string);
		},

		trim(string) {
		    if(string.length <= 150)     return string;
		    else if(150 <= 3)            return string.slice(0, 150) + "...";
		    else                        return string.slice(0, 150 - 3) + "...";
		},

		telfordStandardDate(dt) {
			return moment(dt).format("MM/DD/Y");
		},
	}
}