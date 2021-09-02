<template>
  <div>
    <div v-if="user.access_token">
      <h2 class="create-title">Update Organisation</h2>

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

      <div class="update-footer">
          <button @click="updateOrganisation"
                  class="update-button">Update</button>

                <router-link :to="'/organisations'" class="back-button">Back</router-link>
      </div>
    </div>
    <div v-else>
      <h1>Unauthenticated.</h1>
    </div>
  </div>
</template>

<script>
    export default {
        name: 'update-organisation',
        data(){
            return {
                user: this.$store.state.user,
                id: this.$route.params.organisation.id,
                name: this.$route.params.organisation.name,
                description: this.$route.params.organisation.description,
                errors: ''
            };
        },
        beforeCreate() {
            if(!this.$store.state.user.access_token){
                this.$router.push('/login');
            }
        },
        methods: {
            updateOrganisation(){
                let data = {
                    name: this.name,
                    description: this.description,
                };

                let headers = {
                    Authorization: 'Bearer ' + this.user.access_token
                };

                this.$axios.patch(this.$conf.serverUrl + '/organisations/' + this.id, data, {headers})
                    .then((response) => {
                        this.$router.push('/organisations');
                    })
                    .catch((error) => {
                        this.errors = error.response.data.message;
                    });
            },
        },
    }
</script>

<style scoped>

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

  .update-button {
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

  .back-button {
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

  .error-message {
      color: red;
      font-size: 14px;
  }

  .update-footer {
      display: flex;
      justify-content: space-between;
  }

</style>
