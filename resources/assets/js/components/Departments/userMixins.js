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
            this.users = users;
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