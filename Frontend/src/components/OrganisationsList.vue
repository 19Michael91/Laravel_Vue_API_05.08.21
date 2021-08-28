<template>
    <div>
        <div v-if="error">
            <h1>{{error}}</h1>
        </div>
        <div v-else>
            <create-organisation @addOrganisation="allOrganisations"></create-organisation>
            <div class="header">
                <h2 class="list-title">List of Organizations</h2>
                <select class="select-status"
                        id="selectStatus"
                        @change="selectStatus">
                    <option selected value="all">All</option>
                    <option value="subscribed">Subscribed</option>
                    <option value="trial">Trial</option>
                </select>
            </div>
            <table class="table-organisations" v-if="isSetOrganisations">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Subscribe</th>
                        <th>User</th>
                        <th>Trial</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(organisation, index) in organisations" :key="organisation.id" >
                        <td>{{organisation.name}}</td>
                        <td>{{organisation.description}}</td>
                        <td>{{organisation.subscribed ? 'Yes' : 'No'}}</td>
                        <td>{{organisation.user.name}}</td>
                        <td>{{organisation.trial_end}}</td>
                        <td>
                            <button type="button"
                                    @click="deleteOrganisation(index)"
                                    class="delete-button">Delete</button>
                            <button type="button"
                                    class="update-button">Update</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="no-organisations-block">
                <h2 class="no-organisations-string">There Is No Organisations Yet</h2>
            </div>
        </div>
    </div>
</template>

<script>
    import CreateOrganisation from './CreateOrganisation'

    export default {
        name: 'organisations-list',
        components: {
            CreateOrganisation,
        },
        data(){
            return {
                user: this.$store.state.user,
                organisations: '',
                error: ''
            };
        },
        computed: {
            isSetOrganisations(){
                return this.organisations.length > 0;
            },
        },
        methods: {
            allOrganisations(){
                let headers = {
                    Authorization: 'Bearer ' + this.user.access_token
                };

                this.$axios.get(this.$conf.serverUrl + '/organisations', {headers})
                    .then((response) => {
                        this.organisations = response.data.data.organisations;
                    })
                    .catch((error) => {
                        this.error = error.response.data.message;
                    });
            },
            selectStatus(event) {
                let params = {
                    [event.target.value]: 1
                };

                let headers = {
                    Authorization: 'Bearer ' + this.user.access_token
                };

                this.$axios.get(this.$conf.serverUrl + '/organisations', {params, headers})
                    .then((response) => {
                        this.organisations = response.data.data.organisations;
                    })
                    .catch((error) => {
                        this.error = error.response.data.message;
                    });
            },
            deleteOrganisation(index){

                let headers = {
                    Authorization: 'Bearer ' + this.user.access_token
                };

                this.$axios.delete(this.$conf.serverUrl + '/organisations/' + this.organisations[index].id, {headers})
                           .then((response) => {
                               this.organisations.splice(index, 1);
                           })
                           .catch((errors) => {
                               console.log(errors);
                           });
            },
        },
        beforeCreate() {
            if(!this.$store.state.user.access_token){
                this.$router.push('/login');
            }
        },
        created() {
            this.allOrganisations();
        }
    }
</script>

<style scoped>

    .header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .list-title {
        display: inline-block;
    }

    .select-status {
        display: inline-block;
        width: 200px;
        height: 40px;
        margin: auto 0;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .table-organisations {
        width: 100%;
    }

    .table-organisations > thead {
        height: 50px;
    }

    .table-organisations > tbody {
        text-align: center;
    }

    table {
        border-collapse:collapse;
        border-spacing:0;
    }

    table tr {
        border-bottom: 1px solid black;
    }

    table tr td {
        word-break: break-all;
        padding: 15px 0;
    }

    .delete-button {
        border: none;
        background-color: #dc3545;
        color: white;
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 7px;
        margin-top: 10px;
    }

    .update-button {
        border: none;
        background-color: #28a745;
        color: white;
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 7px;
        margin-top: 10px;
    }

    .no-organisations-block {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .no-organisations-string {
        display: inline-block;
    }

</style>
