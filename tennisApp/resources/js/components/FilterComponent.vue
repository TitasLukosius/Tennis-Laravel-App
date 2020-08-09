<template>
    <div class="all-players">
        <form
            @submit="onSubmit"
            @reset="onReset"
            v-if="show"
            method="post"
        >
            <label>
                <span>Search by city:</span>
                <input type="text" v-model="form.search" placeholder="pvz.: Vilnius" required>
            </label>
            <button type="submit">Search</button>
            <button type="reset">All Users</button>
        </form>
        <table class="table-users">
            <thead>
            <tr>
                <th v-for="header in headers">{{ header }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="players in output" :key="output.id">
                <td>{{players.name}}</td>
                <td>{{players.surname}}</td>
                <td>{{players.city}}</td>
                <td>{{players.NTRP}}</td>
                <td><a :href="'users-info/'+players.id">Visit Profile</a></td>
                <td><a :href="'users-info/'+players.id+'/sendInvitation/'">Invite</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                form: {
                    search: '',
                },
                output: this.getAll(),
                headers:[
                    'Name',
                    'Surname',
                    'City',
                    'NTRP level',
                    '',
                    ''
                ],
                show: true
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                let currentObj = this;
                return axios.post('users-info/filterPlayers', this.form)
                    .then(function (response) {
                        currentObj.output = response.data
                    })
                    .catch(error => {
                        let er = error.response.data.errors;
                        let ov = Object.values(er);
                        alert(ov);
                    })
            },
            onReset(evt) {
                evt.preventDefault();
                this.getAll();
                this.form.search = ''
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },
            getAll() {
                let currentObj = this;
                return axios.post('users-info/filterPlayers', this.form)
                    .then(function (response) {
                        currentObj.output = response.data
                    })
                    .catch(error =>{
                        let er = error.response.data.errors;
                        let ov = Object.values(er);
                        alert(ov);
                    })
            }
        }
    }

</script>
<style scoped>

</style>
