<template>
  <table class="table table-hover table-responsive-md">
    <thead>
      <tr>
        <th v-for="titulo, key in titulos" :key="key">
          {{titulo}}
        </th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="contato in data" :key="contato.id">
        <td>{{contato.nome}}</td>
        <td>{{contato.email}}</td>
        <td>{{contato.endereco}}</td>
        <td>{{contato.numeros.numero_telefone}}</td>
        <td>
          <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#visualizarContatoModal" @click="setStore(contato), limpa()" >Visualizar</button>
          <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#atualizarContatoModal" @click="setStore(contato)">Editar</button>
          <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#removerContatoModal" @click="setStore(contato), limpa()">Remover</button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
    export default{
        props: ['data', 'titulos'],
        methods:{
          setStore(contato){
            this.$store.state.contato = contato
          },
          limpa(){
            this.$store.state.transacao.mensagem = ''
            this.$store.state.transacao.status = null
          }
        }
    }
</script>