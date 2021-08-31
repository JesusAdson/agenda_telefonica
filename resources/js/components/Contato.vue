<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!-- INICIO CARD BUSCA CONTATOS-->
        <card-component titulo="Buscar contatos">
          <template v-slot:conteudo>
            <div class="form-row">
              <div class="col-mb-3">
                <input-component
                  titulo="Nome"
                  id="nome"
                  id-help="nomeHelp"
                  texto-ajuda="Opcional. Insira um nome para pesquisar"
                >
                  <input
                    type="text"
                    class="form-control"
                    name="name"
                    id="nome"
                    aria-describedby="nomeHelp"
                  />
                </input-component>
              </div>
              <div class="col-mb-3 ml-5">
                <input-component
                  titulo="ID"
                  id="inputID"
                  id-help="idHelp"
                  texto-ajuda="Opcional. Insira um ID para pesquisar"
                >
                  <input
                    type="number"
                    class="form-control"
                    id="inputID"
                    aria-describedby="idHelp"
                  />
                </input-component>
              </div>
            </div>
          </template>
          <template v-slot:rodape>
            <button
              type="submit"
              class="btn btn-primary btn-sm float-right"
              @click="buscar()"
            >
              Pesquisar
            </button>
          </template>
        </card-component>
        <!-- FIM CARD BUSCA -->

        <!-- INICIO CARD LISTA -->
        <card-component titulo="Listagem de contatos">
          <template v-slot:conteudo>
            <table-component></table-component>
          </template>
          <template v-slot:rodape>
            <button
              class="btn btn-primary btn-sm float-right"
              data-toggle="modal"
              data-target="#modalContato"
            >
              Adicionar
            </button>
          </template>
        </card-component>
        <!-- FIM CARD LISTAGEM -->
        <!-- MODAL ADD CONTATO -->
        <modal-component titulo="Adicionar Contato" id="modalContato">
          <template v-slot:conteudo>
            <form action="" @submit.prevent=salvar()>
                <input type="hidden" name="_token" :value="token_csrf">
              <div class="form-row">
                <div class="col-md-6">
                  <input-component
                    titulo="Nome"
                    id="novoNome"
                    id-help="novoNomeHelp"
                    texto-ajuda="Informe o nome do contato."
                  >
                    <input
                      type="text"
                      class="form-control"
                      id="novoNome"
                      aria-describedby="novoNomeHelp"
                      placeholder="Nome do contato"
                      v-model="nomeContato"
                    />
                  </input-component>
                </div>
                <div class="col-md-6">
                  <input-component
                    titulo="Email"
                    id="novoEmail"
                    id-help="novoEmailHelp"
                    texto-ajuda="Opcional. Informe o email do contato."
                  >
                    <input
                      type="email"
                      class="form-control"
                      id="novoEmail"
                      aria-describedby="novoEmailHelp"
                      placeholder="Email"
                      v-model="emailContato"
                    />
                  </input-component>
                </div>
                <div class="col-md-4">
                  <input-component
                    titulo="Endereço"
                    id="novoEndereco"
                    id-help="novoEnderecoHelp"
                    texto-ajuda="Opcional. Informe o endereço do contato."
                  >
                    <input
                      type="email"
                      class="form-control"
                      id="novoEndereco"
                      aria-describedby="novoEnderecoHelp"
                      placeholder="Endereço"
                      v-model="enderecoContato"
                    />
                  </input-component>
                </div>
                <div class="col-md-4">
                  <input-component
                    titulo="Telefone"
                    id="novoTelefone"
                    id-help="novoTelefoneHelp"
                    texto-ajuda="Informe o número de telefone do contato."
                  >
                    <input
                      type="text"
                      class="form-control"
                      id="novoTelefone"
                      aria-describedby="novoTelefoneHelp"
                      placeholder="Número"
                      v-model="numeroContato"
                    />
                  </input-component>
                </div>
                <div class="col-md-4">
                  <input-component
                    titulo="Grupo"
                    id="novoGrupo"
                    id-help="novoGrupoHelp"
                    texto-ajuda="Informe o grupo do contato."
                  >
                    <select
                      id="novoGrupo"
                      aria-describedby="novoGrupoHelp"
                      class="form-control"
                      v-model="grupoContato"
                    >
                      <option value="" selected disabled>
                        Selecione um grupo
                      </option>
                      <option value="1">Casa</option>
                      <option value="2">Trabalho</option>
                    </select>
                  </input-component>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                  Salvar
                </button>
              </div>
            </form>
          </template>
          <template v-slot:rodape>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Fechar
            </button>
          </template>
        </modal-component>
        <!-- FIM MODAL ADD CONTATO -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props:['token_csrf'],
  data() {
    return {
      urlBase: "http://localhost:8000/api/contatos",
      nomeContato: "",
      emailContato: "",
      enderecoContato: "",
      numeroContato: "",
      grupoContato: "",
      contatos: null,
    };
  },
  methods: {
    salvar() {
      let cookie = document.cookie;
      let token = cookie.split("token=");

      let numeros = [];
      numeros.push(this.numeroContato);

      console.log(
        this.nomeContato,
        this.emailContato,
        this.enderecoContato,
        numeros,
        this.grupoContato
      );

      let options = {
        headers: {
          'Accept': "application/json",
          "Content-Type": "application/json",
          'Authorization': `Bearer ${token[1]}`,
        }
      };

    
      axios
        .post(this.urlBase, {
            nome: this.nomeContato,
            email: this.emailContato,
            endereco: this.enderecoContato,
            grupo_id: this.grupoContato,
            numero_telefone: numeros
        }, options)
        .then((response) => console.log(response))
        .catch((errors) => {
          console.log(errors.response.data);
        });
    },
    buscar() {
      // funcionando
      axios
        .get(this.urlBase + '/1')
        .then((response) => (this.contatos = response.data))
        .then((data) => {
          console.log(data);
        })
        .catch((error) => {
          console.log(error + " erro");
        });
    },
  },
};
</script>   