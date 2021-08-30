<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Login (vue)</div>
                <div class="card-body">
                    <form method="POST" action="" @submit.prevent="login($event)">
                        <input type="hidden" name="_token" :value="token_csrf">
                        <div class="form-group row">
                            <label for="inputEmail" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" v-model="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSenha" class="col-md-4 col-form-label text-md-right">Senha</label>
                            <div class="col-md-6">
                                <input type="password" name="password" id="inputSenha" class="form-control" placeholder="Senha" v-model="password">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default{
        props: ['token_csrf'],
        data(){
            return{
                email: '',
                password: ''
            }
        },
        methods: {
            login(e){
               let url = 'http://localhost:8000/api/login'
               let config = {
                   method: 'post',
                   body: new URLSearchParams({
                       email: this.email,
                       password: this.password
                   })
               }

               fetch(url, config)
                .then(response => response.json())
                .then(data => {
                    if(data.access_token){
                        document.cookie='token='+data.access_token+';SameSite=Lax'
                    }
                    e.target.submit()
                })
            }
        }

    }
</script>