<template>
    <div>
        <div v-if="error">
            <h1>{{error}}</h1>
        </div>
        <div v-else>
          <create-organisation @addOrganisation="allOrganisations"></create-organisation>
            <div>
                <div class="header">
                    <h2 class="list-title">List of Organizations</h2>
                    <select class="select-status"
                            id="selectStatus"
                            v-if="organisations"
                            @change="selectStatus">
                        <option selected value="all">All</option>
                        <option value="subscribed">Subscribed</option>
                        <option value="trial">Trial</option>
                    </select>
                </div>

                <table class="table-organisations"
                       v-if="organisations">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Subscribe</th>
                            <th>User</th>
                            <th>Trial</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="organisation in organisations" :key="organisation.id" >
                            <td>{{organisation.name}}</td>
                            <td>{{organisation.description}}</td>
                            <td>{{organisation.subscribed ? 'Yes' : 'No'}}</td>
                            <td>{{organisation.user.name}}</td>
                            <td>{{organisation.trial_end}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import CreateOrganisation from './CreateOrganisation'

    export default {
        name: 'organisations-list',
        components: {
            CreateOrganisation
        },
        data(){
            return {
                user: this.$store.state.user,
                organisations: '',
                error: ''
            };
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
            }
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

</style>
