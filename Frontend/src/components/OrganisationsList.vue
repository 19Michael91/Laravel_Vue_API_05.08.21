<template>
    <div>
        <div v-if="error">
            <h1>{{error}}</h1>
        </div>
        <div v-else>
            <create-organisation @addOrganisation="allOrganisations"
                                 @createFlash="createFlash"></create-organisation>
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
            <table v-if="isSetOrganisation"
                   class="table-organisations">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Subscribed</th>
                        <th>User</th>
                        <th>Trial</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(organisation, index) in organisations" :key="organisation.id" >
                        <td>{{organisation.name}}</td>
                        <td>{{organisation.description}}</td>
                        <td>
                            <div :class="organisation.subscribed ? 'sub-status' : 'unsub-status'">
                                {{organisation.subscribed ? 'Yes' : 'No'}}
                            </div>
                            <button type="button"
                                    @click="subscriptionToggle(index)"
                                    :class="organisation.subscribed ? 'unsub-button' : 'sub-button'">
                                {{organisation.subscribed ? 'Unsubscribe' : 'Subscribe'}}
                            </button>
                        </td>
                        <td>{{organisation.user.name}}</td>
                        <td>{{organisation.trial_end}}</td>
                        <td>
                            <button type="button"
                                    @click="deleteOrganisation(index)"
                                    class="danger-button">Delete</button>

                            <router-link :to="{ name: 'editOrganisation', params: { organisation: organisation }}"
                                         class="success-button">Edit</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="no-organisations-block">
                <h2 class="no-organisations-string">There Is No Organisations Yet</h2>
            </div>
        </div>

        <flash></flash>
    </div>
</template>

<script>
    import CreateOrganisation from './CreateOrganisation'
    import Flash from './Flash'

    export default {
        name: 'organisations-list',
        components: {
            CreateOrganisation,
            Flash
        },
        data(){
            return {
                user: this.$store.state.user,
                organisations: '',
                error: ''
            };
        },
        beforeCreate() {
            if(!this.$store.state.user.access_token){
                this.$router.push('/login');
            }
        },
        created() {
            this.allOrganisations();
        },
        computed: {
            isSetOrganisation(){
                return this.organisations.length > 0;
            }
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
                this.$rotation.startLogoRotation('logo');

                let headers = {
                    Authorization: 'Bearer ' + this.user.access_token
                };

                this.$axios.delete(this.$conf.serverUrl + '/organisations/' + this.organisations[index].id, {headers})
                           .then((response) => {
                               this.organisations.splice(index, 1);
                               this.$emit('flash', response.data);
                               this.$rotation.stopLogoRotation('logo');
                           })
                           .catch((errors) => {
                               this.$emit('flash', errors);
                               this.$rotation.stopLogoRotation('logo');
                           });
            },
            subscriptionToggle(index){
                this.$rotation.startLogoRotation('logo');

                let headers = {
                    Authorization: 'Bearer ' + this.user.access_token
                };

                this.$axios.post(this.$conf.serverUrl + '/organisations/'
                                                      + this.organisations[index].id
                                                      + '/subscription', null, {headers})
                    .then((response) => {
                        this.organisations[index].subscribed = response.data.data.subscribed;
                        this.$emit('flash', response.data);
                        this.$rotation.stopLogoRotation('logo');
                    })
                    .catch((errors) => {
                        this.$emit('flash', errors);
                        this.$rotation.stopLogoRotation('logo');
                    });
            },
            createFlash(data){
                data.message = data.success === true ? data.message
                                                     : 'Organization creation error';
                this.$emit('flash', data);
            },
        },
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

    thead {
        position: sticky;
        top: 0;
        background-color: #c7e6ec;
    }

    table tr {
        border-bottom: 1px solid black;
    }

    table tr td {
        word-break: break-all;
        padding: 15px 0;
    }

    .danger-button {
        width: max-content;
        display: inline-block;
        border: none;
        background-color: #fb1700;
        color: white;
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 7px;
        margin-top: 10px;
    }

    .success-button {
        width: max-content;
        display: inline-block;
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
        text-decoration: none;
    }

    .sub-button {
        width: max-content;
        display: inline-block;
        border: none;
        background-color: #17a2b8;
        color: white;
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        padding: 8px 8px;
        font-size: 13px;
        border-radius: 7px;
        margin-top: 10px;
        text-decoration: none;
    }

    .unsub-button {
        width: max-content;
        display: inline-block;
        border: none;
        background-color: #ef5665;
        color: white;
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        padding: 8px 8px;
        font-size: 12px;
        border-radius: 7px;
        margin-top: 10px;
    }

    .sub-status {
        color: #04a7c1;
    }

    .unsub-status {
        color: #ef5665;
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
