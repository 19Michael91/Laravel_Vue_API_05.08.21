<template>
  <div>
      <h2 class="login-title">Login</h2>

      <div v-if="errors.credentials" class="error-message">
          * {{errors.credentials[0]}}
      </div>

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

      <div class="login-footer">
          <button @click="login"
                  class="login-button">Login</button>

          <router-link :to="'/registration'" class="register-button">Registration</router-link>
      </div>
  </div>
</template>

<script>
    export default {
        name: 'login',
        data(){
            return {
                email: '',
                password: '',
                errors: '',
            };
        },
        methods: {
            login(){
                let data = {
                    email: this.email,
                    password: this.password,
                };

                this.$axios.post(this.$conf.serverUrl + '/login', data)
                .then((response) => {
                    if(response.data.data.access_token){
                        this.$store.state.user = response.data.data;
                        this.$router.push('/organisations');
                    }
                })
                .catch((error) => {
                    this.errors = error.response.data.message;
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

    .login-title {
        text-align: center;
    }

    .login-footer {
        display: flex;
        justify-content: space-between;
    }

    .login-button {
        border: none;
        background-color: #204cdc;
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

    .register-button {
        border: none;
        background-color: #00bf49;
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
