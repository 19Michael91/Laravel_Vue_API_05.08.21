<template>
    <div>
        <h2 class="registration-title">Registration</h2>

        <div v-if="errors.email">
            <ul>
                <li v-for="message in errors.email" class="error-message">
                    * {{message}}
                </li>
            </ul>
        </div>

        <input type="text"
               name="email"
               class="api-input"
               v-model="email"
               placeholder="Email">

        <div v-if="errors.name">
            <ul>
                <li v-for="message in errors.name" class="error-message">
                    * {{message}}
                </li>
            </ul>
        </div>

        <input type="text"
               name="email"
               class="api-input"
               v-model="name"
               placeholder="Name">

        <div v-if="errors.password">
            <ul>
                <li v-for="message in errors.password" class="error-message">
                    * {{message}}
                </li>
            </ul>
        </div>
        <input type="password"
               name="password"
               class="api-input"
               v-model="password"
               placeholder="Password">

        <div class="registration-footer">
            <button @click="registration"
                    class="registration-button">Registration</button>

            <router-link :to="'/login'" class="back-button">Back</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'registration',
        data(){
            return {
                email: '',
                name: '',
                password: '',
                errors: '',
            };
        },
        methods: {
            registration(){
                this.$rotation.startLogoRotation('logo');

                let data = {
                    email: this.email,
                    name: this.name,
                    password: this.password,
                };

                this.$axios.post(this.$conf.serverUrl + '/register', data)
                     .then((response) => {
                         if(response.data.data.access_token){
                             this.$store.state.user = response.data.data;
                             this.$router.push('/organisations');
                         }
                         this.$rotation.stopLogoRotation('logo');
                     })
                     .catch((error) => {
                         this.errors = error.response.data.message;
                         this.$rotation.stopLogoRotation('logo');
                     });
            },
        },
    }
</script>

<style scoped>

    ul {
        margin: 0;
        padding: 0;
    }

    li {
        list-style-type: none;
    }

    .error-message {
        color: red;
        font-size: 14px;
    }

    .api-input {
        width: 100%;
        padding: 10px 18px;
        font-size: 18px;
        margin-bottom: 20px;
        margin-top: 5px;
    }

    .api-input:focus {
        outline: 0;
    }

    .registration-title {
        text-align: center;
    }

    .registration-footer {
        display: flex;
        justify-content: space-between;
    }

    .registration-button {
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
        margin-top: 10px;
    }

    .back-button{
        border: none;
        background-color: #28a745;
        color: white;
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        padding: 8px 20px;
        font-size: 19px;
        font-weight: bold;
        border-radius: 7px;
        margin-top: 10px;
        text-decoration: none;
    }

</style>
