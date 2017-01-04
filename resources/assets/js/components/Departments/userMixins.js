export default {
    data() {
        return {
            users: {},
        }
    },

    computed: {
        hasUsers() {
            return  ! _.isEmpty( this.users );
        }
    },



    
    methods: {
        setUsers(users) {
            console.log(users);
            
            // this.users = _.toArray(JSON.parse(users));
        },

        sanitizeUser(user) {
            const departments = this.sanitizeDepartment(user.department);
            return {
                email: user.email,
                department: departments
            }
        },

        resetUsers() {
            this.users = null;
        }

    }
}