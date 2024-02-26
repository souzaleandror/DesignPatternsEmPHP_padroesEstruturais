#### 26/02/2024

CURSO Design Patterns em PHP: padrões estruturais

@01-Adapters para reutilizar dependências

@@01
Introdução

[00:00] Olá, pessoal, boas-vindas à Alura. Meu nome é Vinícius Dias e eu vou guiar vocês nesse treinamento de padrões de projetos estruturais utilizando PHP.
[00:09] Nessa classe de padrões vamos ver alguns padrões, algumas formas de desenvolver que farão com que consigamos montar objetos e classes em estruturas maiores, mas mantendo isso flexível, extensível e principalmente manutenível.

[00:25] Ou seja, não vamos estragar nosso código ao unir classes para formar estruturas maiores. Veremos como montar estruturas de classe bem interessantes.

[00:35] Vamos começar pelo Adapter. Veremos como ter uma implementação que faz requisições HTTP utilizando componentes diferentes, utilizando cURL, file_get_contents contentes, o que for; isso não importa para nossa regra de negócio.

[00:48] Veremos como gerar um relatório bastante interessante onde podemos salvar um orçamento ou um pedido em XML, em ZIP ou qualquer outro formato, organizando essa estrutura de forma que nossas classes não cresçam para sempre.

[01:00] Veremos como representar nossos objetos, como são nossos orçamentos e itens de orçamento como uma árvore, e conseguiremos percorrer por toda essa árvore até pegar o valor total desse orçamento. Vamos aprender como adicionar comportamento em tempo de execução utilizando o Decorator.

[01:18] Vamos ver sobre o Facade, que é um padrão bastante polêmico que hoje em dia seu nome tem sido citado bastante, embora nem sempre tenha sido aplicado da forma mais pura, vamos dizer assim. É um padrão onde fornecemos uma API mais simples para uma parte de um sistema mais complexo.

[01:35] Veremos como poupar memória com o Flyweight e porque isso nem sempre é uma boa ideia. E veremos como interceptar acesso a objetos utilizando Proxy. Enfim, veremos bastantes padrões de projeto nesse treinamento, então já pega sua xícara de café e vem para o próximo vídeo para já começarmos a colocar a mão na massa.

[01:53] Já te adianto que caso fique alguma dúvida durante esse treinamento você pode ficar à vontade. Não hesite, abra uma dúvida aqui no fórum da Alura. Eu tento responder pessoalmente sempre que eu posso, mas quando eu não consigo a nossa comunidade é bastante solícita e nossas alunas, alunos e moderadores estão sempre prontos e dispostos a ajudar. Espero que você aproveite bastante e, mais uma vez, te espero no próximo vídeo para colocarmos a mão na massa.

@@02
Projeto inicial do treinamento
O projeto inicial desde treinamento é o projeto implementado no treinamento anterior. Então, caso você tenha feito o treinamento anterior, pode prosseguir com o mesmo projeto.
Caso você não tenha feito o treinamento anterior ou não tenha mais o projeto, você pode baixá-lo aqui.

@@03
API de registro de orçamento

[00:00] Bem-vindos de volta e vamos dar uma olhada no nosso projeto. Caso você não tenha feito nosso treinamento de padrões de projeto comportamentais, recomendo que você faça, porque construímos esse projeto e já aprendemos vários padrões de projeto. E agora daremos continuidade no mesmo projeto, aprendendo os padrões estruturais.
[00:19] Então temos uma classe de orçamento, que foi onde tudo começou. E nessa classe de orçamento temos “quantidade de itens; valor; o estado atual”, então temos o padrão state sendo aplicado, bastante coisa.

[00:33] E temos descontos sendo aplicados, impostos sendo aplicados, vários impostos, vários descontos possíveis, temos ações ao gerar um pedido. Para isso temos obviamente um pedido, então bastante coisa já aconteceu.

[00:47] Só que o que queremos fazer agora é pegar um orçamento, e depois que ele for finalizado precisamos chamar uma API para registrar esse orçamento. Porque nessa API algumas regras de negócio acontecem, o que não importa para essa aplicação, mas sabemos que precisamos chamar essa API.

[01:06] Então vou criar uma nova classe para chamar essa API de “registro de orçamento”. Vou colocar na raiz mesmo. Como eu já comentei no treinamento anterior, eu não estou organizando as pastas direito como poderia para não perdermos tempo pensando na arquitetura e podermos focar nos padrões.

[01:30] Então temos a classe RegistroOrcamento. Eu vou criar uma nova função chamada registrar, que recebe um orçamento e não devolve nada: public function registrar(Orcamento $orcamento): void.

[01:44] Então eu preciso chamar uma API de registro. E enquanto eu chamo essa API eu preciso enviar os dados do orçamento.

[01:59] Então vamos implementar isso. Como eu vou enviar os dados do orçamento nessa chamada de API de registro? Como eu chamo uma API utilizando PHP? Existem várias formas. A mais simples: eu poderia fazer um file_get_contents(filename: 'http://api.registrar.orcamento');.

[02:20] Assim eu consigo chamar essa API, mas por padrão essa requisição vai ser do verbo GET, e o que estamos fazendo teria que ser uma requisição do verbo POST, do HTTP. Se você não está entendendo isso, existem cursos de HTTP muito bons na Alura, mas esse não é o foco do treinamento.

[02:36] Mas a questão é: por padrão essa requisição não é o suficiente. Então eu teria que trabalhar com contextos de stream para definir o corpo da mensagem, o verbo. Eu não vou trabalhar com isso. Nós temos um treinamento de streams também, que fala sobre isso, mas eu acho isso um pouco complexo.

[02:54] Então eu posso usar, por exemplo, o cURL. Eu sei que com curl_init eu inicializo um objeto do cURL, e eu posso passar os dados do post. Só que eu não me lembro de cabeça como trabalhar com cURL. A API dele, as funções são um pouco complexas de lembrar. Então eu poderia, por exemplo, utilizar o Guzzle, que é uma biblioteca que podemos instalar com o Composer.

[03:16] Então repare que existem várias formas de implementar e isso é um detalhe de infraestrutura. Ele não deveria estar junto com essa minha classe RegistroOrcamento. Essa minha classe chama uma API. Agora, como essa requisição HTTP será feita por baixo dos panos não me importa.

[03:34] Então o que eu quero fazer é ter uma classe específica, seja lá qual ela for, para realizar uma requisição HTTP genérica; e essa classe de registro de orçamento vai utilizar essa outra classe que faz uma requisição HTTP para realizar a requisição em si.

[03:53] Então o que eu quero é separar as responsabilidades para, independente de qual for a implementação, seja com file_get_contents, com cURL, com Guzzle, pegar esse adaptador de uma requisição HTTP e utilizar no meu registro de orçamento. É isso que faremos no próximo vídeo.

@@04
Dependências
Baseado em treinamentos anteriores, já sabemos que classes podem possuir dependências para realizar suas tarefas. No último vídeo, a nossa classe passou a possuir uma dependência de alguma outra implementação que consiga realizar chamadas HTTP.
Qual das alternativas a seguir é uma simples recomendação para trabalhar com dependências?

Depender sempre de abstrações, e não de implementações específicas
 
Alternativa correta! Inclusive, este é um dos princípio de SOLID (Dependency Inversion Principle, a letra D). Devemos sempre preferir depender de abstrações, ou seja, interfaces ou classes abstratas, sempre que possível, ao invés de implementações específicas. Mesmo que dependamos de uma classe concreta, o ideal é depender de sua interface, ou seja, uma chamada de método público, e não uma série de chamadas.
Alternativa correta
Quanto mais dependências, melhor, para deixar a nossa classe mais simples
 
Alternativa correta
Classes dependentes devem estar sempre na mesma pasta/namespace
 
Alternativa errada! Isso não é uma recomendação real. É muito comum dependermos de classes em namespaces diferentes.

@@05
Criando um adapter

[00:00] Bem-vindos de volta. Como eu comentei, precisamos criar essa classe específica que vai adaptar algum detalhe de infraestrutura, alguma forma de fazer uma requisição HTTP para uma interface comum, para o meu registro de orçamento não se importar com como isso vai ser chamado.
[00:17] Então para isso eu vou criar uma nova pasta que vou chamar de “Http”, não precisa ter um nome muito mais claro do que isso.

[00:25] E primeiro eu preciso criar essa interface, o contrato que será atendido. Vou chamar de “HttpAdapter”, porque é o adaptador de como fazer uma chamada HTTP.

[00:39] Eu só vou criar o método que eu preciso, que é public funcion post(string $url, array $data = []): void;. É só isso que eu preciso por enquanto, ele não vai retornar nada.

[01:00] Você poderia, obviamente, criar de forma mais genérica, onde ele devolveria resposta e esse tipo de coisa. Mas para o nosso caso isso já é totalmente suficiente.

[01:11] Agora no meu registro de orçamento eu vou precisar no meu “Construtor” receber algum HTTP Adapter: public function _construct(HttpAdapter $http). Vou criar uma propriedade.

[01:26] Lembrando que se você não estiver utilizando PHP Storm, você pode só criar essa propriedade privada private HttpAdapter $http; e inicializar o que receber do “Construtor”. Mas utilizando o PHP Storm é só dar “Alt + Enter” e “Initialize field”, que ele já cria a propriedade para nós. Então criei. Tenho algum adaptador de requisição HTTP, então agora posso fazer $this->http->post(url ‘http://api.registrar.orcamento’ [.

[01:58] E dentro eu mando os dados desse orçamento, que tem o estado atual, quantidade de itens e valor: [‘valor’ => $orcamento->valor, ‘quantidadeItens’ => $orcamento->quantidadeItens.

[02:20] E como eu disse, só vamos registrar um orçamento quando ele já estiver finalizado. Então eu posso até verificar: if (!$orcamento->estadoAtual instanceof Finalizado). Se não for desse estado posso lançar uma exceção: throw new \DomainException(message: ‘Apenas orçamentos finalizados podem ser registrados na API’);.

[02:51] Então vamos recapitular o que fizemos. Nós criamos uma interface de algum adaptador HTTP. Ou seja, pode ser com file_get_contents, pode ser com cURL, com Guzzle, com React PHP, com qualquer biblioteca que faça requisições HTTP.

[03:07] Então como essa interface criada para atender os nossos objetivos, para atender o que o meu registro de orçamento espera, eu recebo agora alguma implementação dessa interface. Recebendo essa implementação, eu consigo fazer o registro do meu orçamento.

[03:23] Só que essa classe é responsável pela regra de negócio de registrar. Então ela pode ter suas regras, suas verificações, e utiliza alguma implementação dessa interface para realizar a ação em si.

[03:36] Então já temos um “Adapter”. Vamos criar uma implementação fictícia. Eu poderia ter, por exemplo, um “CurlHttpAdapter”.

[03:45] Como eu falei, eu não me lembro exatamente como utilizar o cURL de cabeça, eu teria que pesquisar. Então, vou criar uma implementação fictícia. Eu teria um recurso do cURL, retornado pelo curl_init para a URL definida: $curl = curl_init($url);.

[04:04] Eu sei que o cURL vai ter um setopt, e dentro eu passo várias opções, como CURLOPT_POST, e passo os dados: curl_setopt($curl, option:CURLOPT_POST, $data);.

[04:25] Vou passar todas as opções que eu teria que passar, e no final eu faria um curl_exec($curl);. Eu executaria essa requisição.

[04:33] Eu tenho uma implementação totalmente válida. E se eu quiser testar isso, se eu quiser fazer um registro de orçamento, vou criar um arquivo chamado “registro-orcamento”. Obviamente isso não vai funcionar na prática porque não temos essa API. Mas eu só vou mostrar que o código funciona. Então require ‘vendor/autoload.php’;. Eu preciso de um registro de orçamento: $registroOrcamento = new RegistroOrcamento();.

[05:11] Talvez você não esteja vendo, mas o PHP Storm já está deixando isso um pouco mais claro, informando que você precisa de um parâmetro que é um HTTP Adapter. Então eu posso muito bem passar o CurlHttpAdapter.

[05:26] E pronto, eu posso agora com meu registro de orçamento registrar algum orçamento. Só que agora o cURL está ficando um pouco lento, preciso de uma implementação assíncrona, então vou utilizar o React PHP. Veremos no próximo vídeo como isso fica fácil.

@@06
Modificando a implementação

[00:00] Bem-vindos de volta. Já vimos que nós temos um serviço, uma classe que realiza alguma regra de negócio, que precisa fazer uma requisição HTTP, que é um detalhe de algum componente externo que vai fazer uma requisição.
[00:13] Só que eu não quero me preocupar com como fazer essa requisição. Então eu extraí uma interface que vai me dar algum adaptador que é alguma classe que saiba fazer uma requisição HTTP.

[00:29] E implementamos de forma fictícia um cURL HTTP Adapter. Só que como está um pouco lento, precisamos de uma nova implementação que vai ser utilizando o React PHP. Vou dar o nome de “ReactPHPHttpAdapter”.

[00:45] Então isso será um novo HTTP Adapter que precisa do método POST. E obviamente eu não vou utilizar, nós precisaríamos de um curso específico sobre React PHP, mas nesse ponto finge que eu instancio o React PHP, preparo os dados e faço a requisição. Por fim echo “ReactPHP”;, só para mostrar que estamos utilizando ele mesmo.

[01:15] E agora no nosso registo de orçamento, que é o arquivo que está utilizando o código, repare como a modificação vai ser sutil, simples. Ao invés de utilizar o cURL Adapter, eu vou utilizar o React HTTP Adapter. Vou importar e pronto. É só isso que eu preciso para fazer isso tudo funcionar.

[01:36] O nosso código continua compilando, ele continua válido. Eu tenho uma implementação completamente diferente, mas eu não precisei nem tocar na minha classe de negócios, na classe que realiza a regra de negócio em si.

[01:50] Então essa forma de separar algum detalhe de uma implementação externa, de pacotes externos, de chamada ao sistema, seja lá o que for, separar de uma classe que precisa disso é conhecido como padrão Adapter. E foi exatamente esse o nome que demos para nossa interface e para cada uma de suas implementações.

[02:11] Se você for fazer uma analogia com o mundo real, pensa nas tomadas. Imagina que você vai viajar do Brasil para os Estados Unidos e você leva seu laptop, seu celular com seu carregador, obviamente, e ao chegar lá você não consegue utilizar a tomada.

[02:25] Por quê? No Brasil nós utilizamos uma implementação de um adaptador, que é a tomada em si, direto na parede. Só que nos Estados Unidos esse plug, essa implementação é diferente. Então precisamos de um Adapter diferente. Então vamos a uma loja, compramos um adaptador de tomada para conseguir utilizar.

[02:45] E se formos para a Europa, vamos utilizar um adaptador diferente. Então para a mesma interface temos várias implementações, várias adaptações possíveis.

[02:55] Outro exemplo bastante comum e bastante didático é: você precisa colocar na sua aplicação um mapa. Só que existem várias API’s que trabalham com mapa: Open Maps, o próprio Google Maps, enfim.

[03:10] Você não quer que sua classe de negócios, como é o caso do nosso registro de orçamento, saiba se está utilizando uma API do Google, do Open Maps ou de qualquer outra. Você quer um adaptador que saiba gerar um mapa.

[03:24] Então você cria uma interface, e dessa interface que você vai utilizar na sua regra de negócios, nas suas lógicas, vão ter várias implementações. E esse é o padrão Adapter.

[03:36] Como fizemos com todos os outros padrões até aqui, caso você queira saber mais, tem toda uma explicação teórica por trás. Mas a prática é bem simples e é exatamente isso. Outro uso também, bastante comum, é quando você tem implementações de chamadas ao sistema como, por exemplo, tentar buscar a data ou a hora.

[03:58] E por que você abstrairia isso num Adapter? Porque, primeiro, você pode utilizar o DateTime do PHP, que é muito simples; você pode utilizar uma biblioteca externa, como Carbon; e isso tanto faz para as nossas regras de negócio.

[04:09] E outro motivo é que caso você queira testar e informar uma data específica, se você utiliza um Adapter você pode acabar tendo mais facilidade para criar dublês de teste, algo que comentamos nos nossos treinamentos de teste.

[04:24] Mas basicamente, se precisamos de uma implementação, de um componente externo, de algo que pode ser modificado, criamos uma interface chamada de Adapter e temos várias implementações para esse Adapter.

[04:36] Então agora que já implementamos essa API, existe uma outra demanda muito interessante. Os nossos orçamentos, nossos pedidos precisam ser exportados; nós precisamos informá-los em alguns formatos diferentes. E vamos começar a tratar sobre isso no próximo capítulo.

@@07
Para saber mais: Adapter
Quando precisamos utilizar código legado ou código de componentes externos em nosso sistema, é muito comum não ter a interface (métodos públicos) batendo com o que a gente precisa, então nesses casos nós criamos adapters.
Esse padrão é muito simples e muito utilizado no dia a dia do desenvolvimento, então vale a pena a sua leitura com mais calma: Adapter.

@@08
Faça como eu fiz
Chegou a hora de você seguir todos os passos realizados por mim durante esta aula. Caso já tenha feito, excelente. Se ainda não, é importante que você execute o que foi visto nos vídeos para poder continuar com a próxima aula.

Continue com os seus estudos, e se houver dúvidas, não hesite em recorrer ao nosso fórum!

@@09
O que aprendemos?
Nesta aula, aprendemos:
Que padrões estruturais nos ajudam a relacionar diversas classes de forma organizada
Que detalhes de infraestrutura devem ser abstraídos através de interfaces
Como o padrão Adapter pode nos ajudar a trocar detalhes de infraestrutura, sem muitas dores de cabeça

