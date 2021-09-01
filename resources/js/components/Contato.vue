<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
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
                    v-model="busca.nome"
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
                    v-model="busca.id"
                  />
                </input-component>
              </div>
            </div>
          </template>
          <template v-slot:rodape>
            <button
              type="submit"
              class="btn btn-primary btn-sm float-right"
              @click="pesquisar()"
            >
              Pesquisar
            </button>
          </template>
        </card-component>
        <!-- FIM CARD BUSCA -->

        <!-- INICIO CARD LISTA P PARAMETROS-->
        <card-component v-if="pesquisa === true" titulo="Resultado da pesquisa">
          <template v-slot:conteudo>
            <table-component
              :data="contatoPesquisa.data"
              :titulos="['Nome', 'Email', 'Endereço', 'Número']"
            ></table-component>
          </template>
          <template v-slot:rodape>
            <button class="btn btn-primary" @click="fecharCard()">
              Listar todos os contatos
            </button>
          </template>
        </card-component>
        <!-- FIM CARD LISTA P PARAMETROS-->

        <!-- INICIO CARD LISTA -->
        <card-component v-if="pesquisa != true" titulo="Listagem de contatos">
          <template v-slot:conteudo>
            <table-component
              :data="contatos.data"
              :titulos="['Nome', 'Email', 'Endereço', 'Número']"
            ></table-component>
          </template>
          <template v-slot:rodape>
            <div class="row">
              <div class="col-10">
                <paginate-component>
                  <li
                    :class="l.active ? 'page-item active' : 'page-item'"
                    v-for="(l, key) in contatos.links"
                    :key="key"
                    @click="paginacao(l)"
                  >
                    <a class="page-link" href="#" v-html="l.label"></a>
                  </li>
                </paginate-component>
              </div>
              <div class="col">
                <button
                  class="btn btn-primary btn-sm float-right"
                  data-toggle="modal"
                  data-target="#modalContato"
                >
                  Adicionar
                </button>
              </div>
            </div>
          </template>
        </card-component>
        <!-- FIM CARD LISTAGEM -->

        <!-- MODAL ADD CONTATO -->
        <modal-component titulo="Adicionar Contato" modalID="modalContato">
          <template v-slot:alertas>
            <alert-component
              tipo="success"
              :message="$store.state.transacao.mensagem"
              titulo="Contato adicionado com sucesso!"
              v-if="$store.state.transacao.status === true"
            ></alert-component>
            <alert-component
              tipo="danger"
              :message="transactionDetails"
              titulo="Erro ao tentar adicionar o contato"
              v-if="transactionStatus === false"
            ></alert-component>
          </template>
          <template v-slot:conteudo>
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
            </div>
          </template>
          <template v-slot:rodape>
            <button type="button" class="btn btn-primary" @click="salvar()">
              Salvar
            </button>
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

        <!-- INICIO MODAL VISU. CONTATO -->
        <modal-component
          titulo="Visualizar Contato"
          modalID="visualizarContatoModal"
        >
          <template v-slot:conteudo>
            <input-component titulo="Nome" id="vNomeContato">
              <input
                type="text"
                id="vNomeContato"
                class="form-control"
                disabled
                :value="$store.state.contato.nome"
              />
            </input-component>
            <input-component titulo="Endereço" id="venderecoContato">
              <input
                type="text"
                id="venderecoContato"
                class="form-control"
                disabled
                :value="$store.state.contato.endereco"
              />
            </input-component>
            <input-component titulo="Email" id="vemailContato">
              <input
                type="text"
                id="vemailContato"
                class="form-control"
                disabled
                :value="$store.state.contato.nome"
              />
            </input-component>
            <input-component titulo="Número" id="vnumeroContato">
              <input
                type="text"
                id="vnumeroContato"
                class="form-control"
                :value="
                  $store.state.contato.numeros
                    ? $store.state.contato.numeros.numero_telefone
                    : ''
                "
                disabled
              />
            </input-component>
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
        <!-- FIM MODAL VISU. CONTATO -->

        <!-- INICIO MODAL ATT. CONTATO -->
        <modal-component
          titulo="Atualizar Contato"
          modalID="atualizarContatoModal"
        >
          <template v-slot:alertas> </template>

          <template v-slot:conteudo>
            <div class="form-row">
              <div class="col-md-6">
                <input-component
                  titulo="Nome"
                  id="aNome"
                  id-help="novoNomeHelp"
                  texto-ajuda="Informe o nome do contato."
                >
                  <input
                    type="text"
                    class="form-control"
                    id="aNome"
                    aria-describedby="novoNomeHelp"
                    placeholder="Nome do contato"
                    v-model="$store.state.contato.nome"
                  />
                </input-component>
              </div>
              <div class="col-md-6">
                <input-component
                  titulo="Email"
                  id="aEmail"
                  id-help="novoEmailHelp"
                  texto-ajuda="Opcional. Informe o email do contato."
                >
                  <input
                    type="email"
                    class="form-control"
                    id="aEmail"
                    aria-describedby="novoEmailHelp"
                    placeholder="Email"
                    v-model="$store.state.contato.email"
                  />
                </input-component>
                {{$store.state.contato}}
              </div>
              <div class="col-md-4">
                <input-component
                  titulo="Endereço"
                  id="aEndereco"
                  id-help="novoEnderecoHelp"
                  texto-ajuda="Opcional. Informe o endereço do contato."
                >
                  <input
                    type="email"
                    class="form-control"
                    id="aEndereco"
                    aria-describedby="novoEnderecoHelp"
                    placeholder="Endereço"
                    v-model="$store.state.contato.endereco"
                  />
                </input-component>
              </div>
              <div class="col-md-4">
                <input-component
                  titulo="Telefone"
                  id="aTelefone"
                  id-help="novoTelefoneHelp"
                  texto-ajuda="Informe o número de telefone do contato."
                >
                  <input
                    type="text"
                    class="form-control"
                    id="aTelefone"
                    aria-describedby="novoTelefoneHelp"
                    placeholder="Número"
                    v-model="$store.state.contato.numeros.numero_telefone"
                  />
                </input-component>
              </div>
            </div>
          </template>
          <template v-slot:rodape>
            <button type="button" class="btn btn-primary" @click="atualizar()">
              Atualizar
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Fechar
            </button>
          </template>
        </modal-component>
        <!-- FIM MODAL ATT CONTATO -->

        <!-- INICIO MODAL REMOÇÃO -->
        <modal-component titulo="Remover Contato" modalID="removerContatoModal">
          <template v-slot:alertas>
            <alert-component
              tipo="success"
              titulo="Sucesso."
              :message="$store.state.transacao.mensagem"
              v-if="$store.state.transacao.status === true"
            ></alert-component>
            <alert-component
              tipo="danger"
              titulo="Não foi possível remover o contato."
              :message="$store.state.transacao.mensagem"
              v-if="$store.state.transacao.status === false"
            ></alert-component>
          </template>
          <template v-slot:conteudo>
            <input-component titulo="Nome" id="rnomeContato">
              <input
                type="text"
                id="rnomeContato"
                class="form-control"
                disabled
                :value="$store.state.contato.nome"
              />
            </input-component>
            <input-component titulo="Endereço" id="renderecoContato">
              <input
                type="text"
                id="renderecoContato"
                class="form-control"
                disabled
                :value="$store.state.contato.endereco"
              />
            </input-component>
            <input-component titulo="Email" id="remailContato">
              <input
                type="text"
                id="remailContato"
                class="form-control"
                disabled
                :value="$store.state.contato.nome"
              />
            </input-component>
            <input-component titulo="Número" id="rnumeroContato">
              <input
                type="text"
                id="rnumeroContato"
                class="form-control"
                :value="
                  $store.state.contato.numeros
                    ? $store.state.contato.numeros.numero_telefone
                    : ''
                "
                disabled
              />
            </input-component>
          </template>
          <template v-slot:rodape>
            <button type="button" class="btn btn-danger" @click="remover()">
              Remover
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Fechar
            </button>
          </template>
        </modal-component>
        <!-- FIM MODAL REMOÇÃO -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    token() {
      let cookie = document.cookie.split(";").find((indice) => {
        return indice.includes("token=");
      });
      let token = cookie.split("=")[1];
      token = "Bearer " + token;

      return token;
    },
  },
  data() {
    return {
      urlBase: "http://localhost:8000/api/contatos",
      nomeContato: "",
      emailContato: "",
      enderecoContato: "",
      numeroContato: "",
      grupoContato: "",
      contatos: { data: [] },
      transactionStatus: null,
      transactionDetails: "",
      busca: {
        nome: null,
        id: null,
      },
      pesquisa: false,
      contatoPesquisa: { data: [] },
    };
  },
  methods: {
    fecharCard() {
      this.pesquisa = false;
    },
    salvar() {
      if (this.transactionStatus != null && this.transactionDetails != null) {
        this.transactionStatus = null;
        this.transactionDetails = "";
      }
      let options = {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          Authorization: this.token,
        },
      };

      axios
        .post(
          this.urlBase,
          {
            nome: this.nomeContato,
            email: this.emailContato,
            endereco: this.enderecoContato,
            numero_telefone: this.numeroContato,
          },
          options
        )
        .then((response) => {
          this.$store.state.transacao.mensagem = response.data.message;
          this.$store.state.transacao.status = true;
          this.listar();
        })
        .catch((errors) => {
          this.$store.state.transacao.mensagem = errors.response.data.message;
          this.$store.state.transacao.status = false;
        });
    },
    listar() {
      axios
        .get(this.urlBase)
        .then((response) => {
          this.contatos = response.data;
        })
        .catch((error) => {
          console.log(error.data.message + "erro");
        });
    },

    paginacao(l) {
      if (l.url) {
        this.urlBase = l.url;
        this.listar();
      }
    },

    pesquisar() {
      axios
        .get(this.urlBase, {
          params: {
            nome: this.busca.nome,
            id: this.busca.id,
          },
        })
        .then((response) => {
          console.log(response);
          this.contatoPesquisa = response;
          this.pesquisa = true;
        })
        .catch((error) => console.log(error.data));
    },

    remover() {
      let confirmar = confirm("Está certo que deseja remover esse registro?");
      if (!confirmar) return false;

      let url = `${this.urlBase}/${this.$store.state.contato.id}`;
      let options = {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          Authorization: this.token,
        },
      };

      axios
        .post(
          url,
          {
            _method: "delete",
          },
          options
        )
        .then((response) => {
          if (response.data.sucesso) {
            this.$store.state.transacao.mensagem = response.data.sucesso;
            this.$store.state.transacao.status = true;
          } else if (response.data.erro) {
            this.$store.state.transacao.mensagem = response.data.erro;
            this.$store.state.transacao.status = false;
          }

          this.listar();
        });
    },

    atualizar(){
      console.log(this.$store.state.contato)
      let url = `${this.urlBase}/${this.$store.state.contato.id}`

      let dadosAtt = 
      {
        _method: 'PATCH',
        //nome: this.$store.state.contato.nome,
        //email: this.$store.state.contato.email,
        endereco: this.$store.state.contato.endereco,
        //numero_telefone: this.$store.state.contato.numeros.numero_telefone,
        //numero_telefone_id: this.$store.state.contato.numeros.id,
      }

      let options = {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: this.token
      }
      axios
      .post(url, dadosAtt, options)
      .then(response =>{
        console.log(response)
        this.listar()
      })
      .catch(error =>{
        console.log(error.response)
      })

    }
  },
  mounted() {
    this.listar();
  },
};
</script>   