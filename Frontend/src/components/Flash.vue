<template>
    <div class="flash"
         v-bind:class="'flash-'+ status"
         v-show="show"
         v-text="message">
    </div>
</template>

<script>
    export default {
        name: 'flash',
        data(){
            return {
                message: null,
                status: null,
                show: false
            };
        },
        mounted() {
            this.$parent.$on('flash', (data) => this.showFlash(data));
        },
        methods: {
            showFlash(data) {
                if(data){
                    this.message  = data.message;
                    this.status   = data.success ? 'success' : 'danger';
                    this.show     = true;
                    this.hide();
                }
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        },
    }
</script>

<style scoped>

    .flash {
        position: fixed;
        right: 25px;
        top: 50px;
        border-radius: 4px;
        padding: 24px 12px;
        font-weight: 600;
        color: #fff;
    }

    .flash-success {
        background-color: #0c7524;
        border: 1px solid #c3e6cb;
    }

    .flash-danger {
        background-color: #da0000;
        border-color: #f5c6cb;
    }

</style>
