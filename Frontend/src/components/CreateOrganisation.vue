<template>
    <div>
        <h2 class="user-name">
            Hello {{$store.state.user.name}}
        </h2>
        <div v-if="user.access_token">
            <h2 class="create-title">Create New Organisation</h2>

            <div v-if="errors.name" class="error-message">
                * {{errors.name[0]}}
            </div>

            <input type="text"
                   class="api-input"
                   v-model="name"
                   placeholder="Organization Name">

            <div v-if="errors.description" class="error-message">
                * {{errors.description[0]}}
            </div>

            <textarea class="api-textarea"
                      v-model="description"
                      placeholder="Organisation Description"></textarea>

            <div class="form-footer">
                <button @click="createOrganisation" class="create-button">Create</button>
            </div>
        </div>
        <div v-else>
            <h1>Unauthenticated.</h1>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'create-organisation',
        data(){
            return {
                user: this.$store.state.user,
                name: '',
                description: '',
                errors: ''
            };
        },
        methods: {
            createOrganisation(){
                this.$rotation.startLogoRotation('logo');

                let data = {
                    name: this.name,
                    description: this.description,
                };

                let headers = {
                    Authorization: 'Bearer ' + this.user.access_token
                };

                this.$axios.post(this.$conf.serverUrl + '/organisations', data, {headers})
                    .then((response) => {
                        this.$emit('addOrganisation');
                        this.name         = '';
                        this.description  = '';
                        this.errors       = '';
                        this.$emit('createFlash', response.data);
                        this.$rotation.stopLogoRotation('logo');
                    })
                    .catch((error) => {
                        this.errors = error.response.data.message;
                        this.$emit('createFlash', error);
                        this.$rotation.stopLogoRotation('logo');
                    });
            },
        },
    }
</script>

<style scoped>

    .user-name {
        display: flex;
        justify-content: flex-end;
    }

    .api-input {
        width: 100%;
        padding: 10px 18px;
        font-size: 18px;
        margin-bottom: 16px;
    }

    .api-input:focus {
        outline: 0;
    }

    .api-textarea {
        width: 100%;
        padding: 15px 18px;
        font-size: 18px;
        margin-bottom: 16px;
        height: 80px;
        resize: none;
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3e50;
    }

    .create-title {
        text-align: center;
    }

    .create-button {
        border: none;
        background-color: #007bff;
        color: white;
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        padding: 8px 20px;
        font-size: 19px;
        font-weight: bold;
        border-radius: 7px;
    }

    .error-message {
      color: red;
      font-size: 14px;
    }

    .form-footer {
        display: flex;
        justify-content: center;
    }

</style>
