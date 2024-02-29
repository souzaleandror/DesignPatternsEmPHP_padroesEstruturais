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

#### 29/02/2024

@02-Exportando Dados com bridge

@@01
Projeto da aula anterior

Caso queira, você pode baixar aqui o projeto do curso no ponto em que paramos na aula anterior.

[Title](https://caelum-online-public.s3.amazonaws.com/1669-php-design-pattern-estrutural/01/php-design-patterns-projeto-completo-aula-1.zip)

@@02
Exportando orçamentos como XML

[Title](php-design-patterns-class1)

[00:00] Bem-vindos de volta a mais um capítulo desse treinamento de padrões de projeto estruturais utilizando PHP.
[00:09] Chegou uma demanda um pouco complexa em que precisamos exportar orçamentos, pedidos como XML. Então vamos começar criando uma classe que exporta um orçamento como XML.

[00:19] Então vou criar uma nova classe. Ela vai ficar num novo diretório chamado relatório, só para começarmos a separar um pouco mais, já que temos várias classes. E vou chamar de “OrcamentoXml”. E vou criar o método public function exportar(Orcamento $orcamento).

[00:45] E podemos implementar de várias formas. Eu posso simplesmente criar uma string em XML; eu posso utilizar aquele componente do PHP chamado Simple XML Element; então vou criá-lo para aprendermos uma coisa nova, até porque já tem muito tempo que eu não uso, então vamos ver se eu me lembro como faz.

[01:05] Eu vou criar um elemento XML simples chamado “orcamento”: $elementoOrcamento = new \SimpleXMLElement(data: ‘<orçamento/>’);. E nesse elemento do orçamento eu posso adicionar filhos, posso adicionar novas tags. Então vou adicionar, por exemplo, uma tag “valor”, que vai ser o valor do orçamento: $elementoOrcamento->addChild(name: ‘valor’, $orcamento->valor);. E também vou adicionar quantidade de itens: $elementoOrcamento->addChild(name: ‘quantidade_itens’, $orcamento->quantidadeItens);.

[01:41] E agora eu posso exportar esse elemento orçamento como XML: return $elementoOrcamento->asXML();. Se eu der um “Ctrl + clique”, eu vejo que se eu não passar um nome de arquivo ele vai retornar uma “string”, exatamente isso que eu quero.

[01:57] Então, montei um elemento XML e estou retornando como “String”: public funcion exportar(Orcamento $orcamento): string.

[02:03] Então tenho uma implementação muito simples. Acabamos aprendendo uma coisa nova, como tratar XML com PHP, bastante legal. Parece muito simples, só que, como eu falei, essa demanda é um pouco mais complexa. E além de exportar em XML, nós precisamos também fazer com que cada orçamento possa ser exportado com o ZIP. Então vamos trabalhar isso no próximo vídeo.

@@03
Para saber mais: XML com PHP

O PHP fornece mais de uma forma de trabalharmos com XML, e uma das mais simples (já dá pra dizer pelo nome) é a SimpleXMLElement.
Com esta extensão do PHP, nós podemos representar elementos em XML de forma muito fácil: SimpleXML.

@@04
Exportando orçamentos como ZIP

[00:00] Bem-vindos de volta. Então da mesma forma como exportamos um orçamento em XML, precisamos exportar esse orçamento em ZIP.
[00:08] Então vamos criar uma nova classe para exportar, chamada “OrcamentoZip”. Eu sei que eu não estou seguindo um padrão, mas eu vou criar esse método exportar que já salva no arquivo, para não ter que retornar. Então public function exportar(Orcamento $orcamento).

[00:29] Eu preciso criar um arquivo em ZIP. Primeiro deixa eu criar um caminho para esse arquivo. Esse caminho vai ser igual ao diretório temporário do sistema, seja onde ele for, uma pasta temporária; um separador de diretório, ou seja, uma barra ou contrabarra no caso do Windows; e o nome do arquivo que eu quero, que vai ser o “orcamento.zip”. Então fica $caminhoArquivo = sys_get_temp_dir() . DIRECTORY_SEPARATOR . ‘orcamento.zip’;.

[00:54] Então agora eu vou criar um arquivo ZIP: $zip = new \ZipArchive();. E vou abrir esse arquivo naquele caminho que eu criei: $zip->open($caminhoArquivo);.

[01:11] Só que esse arquivo nesse caminho ainda não existe. Então eu vou informar para esse meu arquivo ZIP criar esse arquivo, se ele não existir ele pode criar: $zip->open($caminhoArquivo, flags \ZipArchive: : CREATE);.

[01:25] Criei o arquivo. Agora eu quero adicionar um outro arquivo nesse ZIP com o conteúdo do orçamento. Nesse ZIP eu vou adicionar a partir de uma string um arquivo com nome “orcamento.serial”, porque eu vou serializar esse orçamento: $zip->addFromString(localname: ‘orcamento.serial’, serialize($orcamento));.

[01:52] Se você não conhece a função serialize do PHP, ela simplesmente pega um objeto e representa esse objeto como string, num formato que o PHP entende. Ele não é muito legível para nós, mas o PHP entende. E depois sabe até transformar de volta em objeto. Mas o que importa é que ele transforma em uma string esse objeto, só isso.

[02:15] Por isso que eu estou colocando a extensão .serial, mas poderia ser qualquer coisa, inclusive vou deixar como orcamento.calopsita.

[02:22] Então eu estou definindo um caminho de um arquivo, que na pasta temporária do sistema se chama “orcamento.zip”. Estou criando um arquivo ZIP e mandando abrir nesse caminho, falando que ele pode criar esse arquivo, caso ele não exista. E estou adicionando, a partir da string desse orçamento, uma nova entrada, um novo arquivo no ZIP chamado “orcamento.calopsita”. Fiz o que eu tinha que fazer nesse arquivo, eu vou fechá-lo.

[02:49] Vamos testar isso. Vou criar um novo arquivo PHP, chamar de “zip” e vamos testar isso tudo. Vou fazer require ‘vendor/autoload.php’;, só para garantir que nosso ZIP está sendo criado.

[03:01] Em seguida $orcamentoZip = new \Alura\DesignPattern\Relatorio\OrcamentoZip();. Vou criar um orçamento: $orcamento = new \Alura\DesignPattern\Orcamento();. Vou definir o valor dele só para garantirmos que está visualizando alguma coisa lá: $orcamento->valor = 500;. E agora no “orcamentoZip” eu vou exportar esse orçamento: $orcamentoZip->exportar($orcamento);.

[03:20] Exportou e ele vai salvar. Onde? Eu já deixei aberto no Windows a minha pasta temporária, que está aparecendo na tela.

[03:27] Se você estiver no Linux é na “\tmp”. Então dependendo do sistema operacional essa pasta temporária muda.

[03:35] Ele vai salvar, então vou tentar executar esse arquivo. Clico com o botão direito, clico em “Run”, e aparentemente funcionou, não tem nenhum erro. E aparece o “orcamento” na pasta.

[03:45] Se eu abrir, eu tenho um arquivo chamado “orcamento.calopsita”. Posso verificar, e tem uma string. E o meu valor realmente é 500, então eu sei que está funcionando.

[04:03] Conseguimos exportar o orçamento em XML e o ZIP em XML. Agora temos que exportar o pedido. Eu preciso criar um classe do pedido em XML e do pedido em ZIP. E se eu quiser exportar alguma outra coisa, uma nota fiscal, eu vou ter criar o arquivo de nota fiscal em ZIP e em XML.

[04:21] E depois disso tudo, se eu quiser exportar isso aqui para Excel? Eu vou ter que sair criando uma classe para cada novo tipo exportado, para cada formato. Então essa árvore de classes vai crescer demais.

[04:35] Então no próximo vídeo vamos começar a modelar uma estrutura para facilitar essa nossa estrutura de exportar conteúdos em diversos formatos.

@@05
Muitas classes

Já começamos bem com o nosso módulo de exportação, separando a responsabilidade de representar o orçamento em cada formato, em classes diferentes. Mas isso gerou um novo problema.
Qual o problema de ter uma classe para representar cada formato de um dado em nosso sistema?


Alternativa correta
A forma como modelamos as classes faz com que, para cada novo conteúdo, várias novas classes sejam necessárias
 
Alternativa correta! A nossa estrutura de classes pode crescer infinitamente e descontroladamente se mantivermos este modelo.
Alternativa correta
Perdemos performance ao ter vários formatos diferentes sendo exportados
 
Alternativa correta
As nossas classes de formato estão muito difíceis de ler

@@06
Exportando conteúdo

[00:00] Bem-vindos de volta. Então, já entendemos a motivação, já entendemos o problema que temos a corrigir. Se eu quiser exportar o pedido agora, eu preciso criar mais duas classes.
[00:12] E se eu quiser exportar em algum formato diferente eu preciso criar uma classe para cada conteúdo que eu estou exportando. Então, claramente não é saudável a forma como estamos fazendo.

[00:26] Então eu vou excluir essas duas classes. E na minha pasta do relatório agora eu quero poder exportar qualquer conteúdo. Então eu vou criar uma nova interface chamada “ConteudoExportado”, cujas implementações vão representar um conteúdo exportado, independente do formato.

[00:47] Esse conteúdo exportado vai ser representado de forma que o PHP entenda. Não sei se é em String, XML, JSON, não quero saber o formato. É um conteúdo exportado.

[01:01] Nós podemos representar isso como “conteúdo”, e eu vou definir que ele será representado como um array associativo do PHP: public function conteudo(): array;.

[01:17] Então o que eu posso exportar no meu sistema? Eu posso exportar um orçamento. Esse orçamento exportado implementa um conteúdo exportado: class OrcamentoExportado implements ConteudoExportado.

[01:34] O que temos no orçamento? Primeiro precisamos de um orçamento. Então vou criar um método Construtor, que vai receber um orçamento e vai inicializar ele: public function _construct(Orcamento $orcamento).

[01:48] E agora no meu conteúdo eu vou retornar um array, onde eu informo o valor desse orçamento e a quantidade de itens: return [ ‘valor’ => $this->orcamento->valor, ‘quantidadeItens’ => $this->orcamento->quantidadeItens ];. Não vou exportar o estado atual, só isso já está bom.

[02:11] Então eu estou representando o conteúdo do meu orçamento exportado. E eu também posso exportar pedidos. Então vamos criar uma classe chamada “PedidoExportado”, que também implementa algum conteúdo exportado: class PedidoExportado implements ConteudoExportado.

[02:29] Então preciso ter o conteúdo. Mas para ter o conteúdo, eu preciso ter um pedido. Então vou seguir aquela mesma lógica: public function _construct(Pedido $pedido).

[02:38] Vou inicializar e o que o pedido tem o orçamento, a data de finalização e nome do cliente. Só vou passar a data de finalização, e vou formatar com dia, mês e ano: return [ ‘data_finalizacao’ => $this->pedido->dataFinalizacao->format(format: ‘d/m/y’),. E o nome do cliente: ’nome_cliente’ => $this->pedido->nomeCliente ];.

[03:16] Tenho os meus conteúdos sendo exportados no PHP ainda, não salvei arquivo, não estou trabalhando com isso. Agora eu quero criar implementações de como exportar esse pedido.

[03:34] Eu já tenho a refinação de uma abstração. Eu tenho uma abstração, que é o conteúdo exportado, só que eu refinei um pouco. Eu tenho agora o orçamento exportado e tenho o pedido exportado. Mas isso ainda está abstrato. Eu vou exportar como, em XML, em ZIP, em JSON, em CSV? Essas implementações, faremos no próximo vídeo.

@@07
Exportação genérica

No último vídeo, nós implementamos uma forma genérica de exportar um conteúdo, sem a necessidade de especificar o formato em que ele será salvo.
Qual a vantagem de exportar os nossos conteúdos de forma genérica?

Alternativa correta
Ganhamos performance ao não nos preocuparmos com o formato
 
Alternativa correta
A partir de um conteúdo genérico, podemos exportar para qualquer formato, sem precisar saber qual o tipo do conteúdo
 
Alternativa correta! Tendo um conteúdo exportado em um formato genérico, nos facilita muito para manter o nosso sistema extensível.
Alternativa correta
Fazemos com que a orientação a objetos não seja necessária

@@08
Implementações de formatos

[00:00] Bem-vindos de volta. Como nossa solução está começando a se formar, deixa eu repetir o problema para caso você tenha se perdido um pouco, e eu vou revisar o que fizemos. Nós precisamos exportar nossos pedidos e nossos orçamentos, ou qualquer conteúdo que tenhamos no sistema em XML e em ZIP, por enquanto.
[00:18] Então começamos a resolver esse problema criando uma classe orçamento XML e uma classe orçamento ZIP. Mas eu precisaria criar pedido XML e pedido ZIP, mais para frente nota fiscal XML e nota fiscal ZIP, clientes XML e clientes ZIP. E isso é insustentável.

[00:38] Então eu separei agora uma abstração de um conteúdo exportado, seja ele qual for. E para cada conteúdo que eu for exportar, agora eu preciso criar uma classe só.

[00:47] Então se eu quero exportar um orçamento eu tenho uma classe. Para o pedido uma classe. Se eu tiver uma nota fiscal eu vou criar uma nota fiscal exportada. Então, para cada novo conteúdo que eu quiser exportar eu crio uma classe.

[01:02] Agora, e os formatos? Vamos criar então um arquivo exportado em si, que vai ter vários formatos. Mas antes vamos começar pela abstração, que é o “ArquivoExportado”. Em qual formato esse arquivo vai estar, como ele vai se salvar não importa. Mas eu tenho arquivos exportados. Esse arquivo exportado vai ter um método salvar e ele vai retornar o caminho desse arquivo: public function salvar (): string;.

[01:38] Então agora que eu tenho uma interface e eu tenho as minhas abstrações de cada conteúdo um pouco mais refinadas, vamos criar as implementações de um arquivo em XML para começar.

[01:50] Vou criar uma classe chamada “ArquivoXmlExportado”, que implementa um arquivo exportado: class AquivoXmlExportado implements ArquivoExportado. Logo, ele tem um método salvar: public function salvar(): string.

[02:08] Eu sei que para criar um conteúdo daquele Simple XML Element eu preciso do nome da tag. Então eu vou receber no construtor uma string do nome do elemento “pai”: public function _construct(string $nomeElementoPai). E vou inicializar.

[02:26] E para que eu vou usar isso? Quando eu for criar o elemento XML no meu Simple XML Element, eu posso informar que aqui vai ter o meu nome do elemento pai: $elementoXml = new \SimpleXMLElement( data: “<{$this->nomeElementoPai} />”).

[02:42] Então se eu passar o orçamento ele vai criar a tag orçamento. Se eu passar o pedido, ele vai criar a tag pedido. Tenho esse elemento, agora, o que eu estou salvando? Então vamos corrigir minha interface que eu criei errado. Eu estou salvando algum conteúdo exportado: public function salvar(ConteudoExportado $conteudoExportado): string;.

[03:04] E é isso que eu estou salvando em XML. O meu conteúdo exportado eu estou salvando num formato que o PHP entende. É um array, onde eu tenho o nome do item, eu tenho o item que vai ter um valor e o seu valor em si. Então vou fazer um foreach nesse conteúdo exportado e eu vou pegar o item e o valor em si: foreach ($conteudoExportado->conteudo() as $item => $valor).

[03:39] Agora nesse meu elemento XML eu vou adicionar uma tag filha com o nome do item, ou seja, se eu estiver exportando um orçamento ele vai ter uma tag de valor e uma tag de quantidade de itens, e o valor será o valor que eu passei no meu conteúdo exportado: $elementoXml->addChild($item, $valor);.

[03:57] Agora eu preciso retornar esse elemento XML como XML, só que eu quero retornar o arquivo salvo. Eu não quero retornar a string. Eu vou criar um arquivo temporário aqui. Para isso temos uma função chamada tmpfile. Então fica $caminhoArquivo = tmpfile();. Essa função simplesmente cria um arquivo temporário na pasta de arquivos temporários do sistema operacional.

[04:32] Então nesse $elementoXml eu vou salvar esse caminho do arquivo. Eu quero retornar só o caminho do arquivo: return $caminhoArquivo;.

[04:49] Vamos recapitular, que eu sei que foi bastante coisa e eu dei uma corrida. Eu tenho a minha abstração de um conteúdo exportado. Eu tenho uma refinação dessa abstração, que pode ser um orçamento exportado ou um pedido exportado. E eu tenho a abstração do formato do arquivo em si.

[05:05] Então agora falta a implementação. E eu estou implementando um arquivo XML importado. E ele vai salvar algum conteúdo, ele vai salvar aquela abstração, a mais abstrata de todas.

[05:18] Então eu tenho uma ponte entre um conteúdo e um formato de arquivo, seja ele qual for. Nessa ponte eu consigo criar novos arquivos individualmente e novos conteúdos exportados individualmente.

[05:33] Então dessa forma, por exemplo, se eu criar uma classe de nota fiscal e quiser exportá-la em XML, ela vai funcionar, desde que eu crie a nota exportada. Se eu quiser salvar isso tudo em JSON eu posso. Basta eu criar um arquivo JSON exportado.

[05:51] Então só para praticarmos um pouco mais, vamos criar o arquivo ZIP exportado. Vou criar uma nova classe chamada “ArquivoZipExportado”. Vai implementar um arquivo exportado, então ele precisa salvar: class ArquivoZipExportado implements ArquivoExportado.

[06:12] Um arquivo ZIP não precisa daquela tag “pai”, então a princípio não vou receber nada no Construtor. Mas eu preciso criar um arquivo ZIP: $arquivoZip = new \ZipArchive();.

[06:24] E eu preciso abrir esse arquivo ZIP: $arquivoZip->open(tmpfile());. Só que eu quero salvar esse nome do arquivo para eu poder retorná-lo: $arquivoZip->open($caminhoArquivo);.

[06:41] Criei o caminho do arquivo, criei o arquivo ZIP e abri ele. Agora nesse arquivo ZIP eu quero adicionar um conteúdo que eu vou chamar: $arquivoZip->addFromString(). E podemos receber isso pelo construtor: public function _construtor(string $nomeArquivoInterno).

[07:12] E eu vou adicionar, chamando de nomeArquivoInterno, seja lá o que for, orçamento, pedido: $arquivoZip->addFromString($this->nomeArquivoInterno, ).

[07:18] E o valor; como esse conteúdo exportado me retorna um array, eu posso serializar, como fizemos com o objeto; eu posso salvar como JSON, posso fazer o que eu quiser. Nesse caso eu vou serializar, então vou chamar a função serialize: $arquivoZip->addFromString($this->nomeArquivoInterno, serialize($conteudoExportado->conteudo());.

[07:39] Agora eu posso primeiramente fechar esse arquivo ZIP: $arquivoZip->close();. E retornar o caminho do arquivo: return $caminhoArquivo.

[07:47] Eu tenho minha implementação completa da ponte entre conteúdos a serem exportados e formatos a serem exportados. Vamos testar isso. Vamos criar um arquivo chamado “Relatorio” para fazermos alguns testes.

[08:04] Então require ‘vendor/autoload.php’;. Vou dar um use em orçamento e em pedido: use Alura\DesignPattern\{Orcamento, Pedido};.

[08:15] Continuando, use Alura\DesignPattern\Relatorio\{OrcamentoExportado, PedidoExportado};. Eu estou importando tudo porque vamos usando para não ficar precisando importar depois. E também use Alura\DesignPattern\Relatorio\{ArquivoXmlExportado, ArquivoZipExportado};.

[08:37] Importei tudo que tenho para importar, vamos começar a implementar. Primeira coisa: eu vou criar um orçamento: $orcamento = new Orcamento();.

[08:45] Esse orçamento vai ter como valor R$500 e como quantidade de itens 7 itens: $orcamento->valor = 500; $orcamento->quantidadeItens = 7;.

[08:53] Agora eu quero exportar esse orçamento. Então: $orcamentoExportado = new OrcamentoExportado($orcamento);. Só que eu vou exportar em XML. Então: $orcamentoExportadoXml = new ArquivoXmlExportado(nomeElementoPai: ‘orcamento’);.

[09:23] E agora eu vou salvar. Eu vou exibir o nome do arquivo salvo, mas eu vou salvar esse conteúdo exportado: echo $orcamentoExportadoXml->salvar($orcamentoExportado);.

[09:35] Então eu tenho o conteúdo em si. Agora eu tenho a ponte entre o meu conteúdo exportado e a minha implementação de um arquivo exportado. Então vou tentar executar isso.

[09:55] Temos dois problemas. Primeiro: a função tmpfile não retorna o caminho do arquivo, ela retorna um resource, ela retorna um arquivo em si. E assim que esse arquivo é fechado ele é excluído automaticamente pelo PHP. Então essa função não vai servir para nós, eu tinha me esquecido desse detalhe.

[10:34] Vou gerar um nome temporário no diretório temporário do sistema, e isso vai começar com um prefixo que podemos definir. Eu vou começar com “xml”. Então fica $caminhoArquivo = tempnam(sys_get_temp_dir(), prefix: ‘xml’);. E vou fazer a mesma coisa no ZIP.

[10:58] E assim criamos, recapitulando, um nome de um arquivo temporário, e ele cria o arquivo com o nome o único no diretório temporário do sistema sys_get_temp_dir(). E esse arquivo vai começar com a palavra “zip”. Vamos tentar executar o relatório agora. Okay, aparentemente gerou o arquivo nessa pasta que ele está mostrando.

[11:25] Vou tentar abrir a pasta. E vamos procurar um arquivo que começa com “xml”. Se eu abrir com o Notepad++ tem um orçamento no valor de R$500 com 7 itens.

[11:43] Agora não quero mais gerar um XML, eu quero gerar um ZIP. Então vou mudar para $orcamentoExportadoXml = new ArquivoZipExportado( nomeArquivoInterno: ‘orcamento.array’);.

[11:57] Se eu executar, vai aparecer também na minha pasta. Vou até renomear para facilitar um pouco. Mas o arquivo foi gerado aparentemente corretamente e está lá o nosso “orcamento.array”.

[12:12] Se eu abrir esse arquivo vai estar serializado um array, onde o valor é 500 e a quantidade de itens é 7. Com isso temos uma extensibilidade, uma maleabilidade na nossa estrutura de classes muito maior.

[12:26] Então se eu quiser ao invés de gerar um orçamento, gerar um pedido, fica $pedido = new Pedido ();. E esse pedido tem o nome do cliente: $pedido->nomeCliente = ‘Vinícius Dias’;. E a data vou colocar como hoje: $pedido->dataFinalizacao = new DateTimeImmutable();.

[13:07] Então agora ao invés de ser um orçamento exportado, é um pedido exportado: $orcamentoExportado = new PedidoExportado($pedido);. Pronto, ele recebe um pedido. E a classe continua sendo arquivo de ZIP. Eu posso até mudar o nome do arquivo para “pedido.array”, isso não vai influenciar.

[13:22] Mas, continua funcionando, está com o nome “zip7923”. E voltando na pasta eu tenho o nosso arquivo “pedido.array”. É um pedido em que a data finalizada é hoje, já no formato que definimos, e o nome do cliente é Vinícius Dias.

[13:50] Se eu quiser como XML eu só troco para $orcamentoExportadoXml = new ArquivoXmlExportado(nomeElementoPai: ‘pedido.array’);. E está exportado o nosso XML. Abrindo a pasta, está o nosso XML que foi gerado agora. Abrindo com o Notepad++ está lá o pedido com data da finalização e nome do cliente.

[14:19] Então com isso implementamos uma estrutura bem mais completa de exportação dos nossos dados. E vamos conversar um pouco melhor, fazer alguns desenhos sobre o que fizemos, mas no próximo vídeo.

@@09
Explicando o padrão

[00:00] Bem-vindos de volta. Vamos discutir sobre o que fizemos nesses últimos vídeos, porque foi um conteúdo bem denso, bem complexo que acabamos implementando. Primeiro tínhamos algo semelhante à imagem que eu estou mostrando.
[00:13] Embora não tivéssemos as interfaces em si, porque eu quis poupar esse tempo, tínhamos basicamente uma forma de exportar os arquivos em ZIP, uma forma de exportar os arquivos em XML. E para cada conteúdo que eu quisesse exportar eu precisava criar uma classe para ZIP e uma para XML.

[00:33] Imagina que eu queira agora salvar também em CSV. Eu teria que pegar toda essa estrutura e gerar em outro lugar o CSV também. Talvez tivesse algum método diferente ou algo assim, mas é basicamente isso.

[00:57] Então eu teria que copiar bastante código e teria que criar duas novas classes. E agora, nesse caso imagina que eu tenho uma nota fiscal que eu quero exportar também. Eu vou ter que criar três novas classes: a nota fiscal em ZIP, nota fiscal em XML e nota fiscal em CSV.

[01:17] Ou seja, a arquitetura não estava escalável, ela não estava saudável de forma que ela pudesse crescer, era inviável. Então nós alteramos esse esquema para ficar semelhante com a seguinte imagem:

[01:29] Temos agora um conteúdo exportado, que é a nossa interface, nossa maior abstração. E nós temos algumas abstrações refinadas, que é o orçamento ou o pedido exportado. E basicamente o nosso arquivo exportado salva um conteúdo exportado. Então esse arquivo exportado que vai salvar um conteúdo exportado pode ser em XML, em ZIP.

[01:58] E suponha que eu queira agora salvar em CSV também. Eu preciso criar uma classe só. E pronto, tenho um novo formato criado com sucesso com uma única classe.

[02:17] Imagina que eu queira agora nesse cenário exportar uma nota.

[02:35] Tenho uma estrutura muito mais escalável, configurável, uma arquitetura que cresce de forma muito mais saudável. E isso, obviamente, pelo nome do curso você deve saber, é um padrão de projeto.

[02:57] E baseado no desenho que esse padrão forma, onde temos uma estrutura, duas partes em cima e algo ligando essas partes, isso parece uma ponte, onde eu tenho uma abstração com suas refinações e uma abstração da implementação em si, de coisas mais concretas. E essa ligação parece uma ponte.

[03:20] Por isso o nome desse padrão é Bridge. Fazemos a ponte entre os nossos conteúdos a serem exportados e os formatos que queremos exportar. Em que outros casos isso pode ser útil? Vamos para o site Refactoring, que eu gosto de tomar como referência. Imagina que eu queira representar duas formas, um cubo e um círculo.

[03:48] Só que, além disso, eles têm cores. Então por enquanto eu tenho vermelho e tenho um azul. Então eu vou ter um formato, uma forma, e eu tenho o círculo vermelho e cubo vermelho. E tenho o círculo azul e o cubo azul.

[04:05] Esse eu tivesse verde? Eu teria o círculo verde e o cubo verde. E se eu tivesse outra cor? Eu teria o círculo e o cubo nessa cor. Se eu tivesse uma outra forma, como um triângulo, eu teria que criar novas classes. Então nós separamos uma coisa da outra e fazemos a ponte. Eu sei que uma forma pode ser uma forma azul ou vermelha, mas eu consigo separar e criar esse formato de ponte.

[04:31] E a partir desse desenho, dessa forma vem o nome do padrão, porque criamos uma ponte entre uma abstração, as abstrações de conteúdo exportado e na implementação de quais arquivos podemos exportar, de como exportar esses conteúdos.

[04:49] Outros exemplos bem comuns de visualizar em tutoriais e em livros é se quisermos criar, por exemplo, um botão. Temos um botão para várias plataformas, e se temos botões diferentes eu teria que criar classes diferentes para cada uma das plataformas.

[05:09] E com esse padrão podemos abstrair e criar essa estrutura de ponte entre uma abstração e uma implementação para que eu tenha a classe que representa um botão e a classe que faz a ponte para a plataforma em si.

[05:21] Então com esse padrão conseguimos fazer com que nossa estrutura de classes cresça de forma muito mais saudável, mais manutenível. E agora que já vimos bastante conteúdo complexo, já trabalhamos bastante, vamos voltar para o início e lembrar dos nossos impostos, que foi como começamos.

[05:41] Nós temos vários impostos, mas sabemos que no Brasil nunca somos tributados com um imposto só. Então se eu quiser aplicar mais de um imposto em cima de algum orçamento, como podemos fazer? Vamos trabalhar com isso no próximo capítulo.

@@10
Para saber mais: Bridge

Em casos bem específicos, durante o desenvolvimento do sistema, podemos nos deparar com uma estrutura de classes que pode acabar crescendo indefinidamente por dois motivos diferentes. Duas características distintas. No nosso simples exemplo, seria pelo conteúdo que seria exportado, e pelo formato em que esse conteúdo seria salvo.
Para resolver esse problema e criar uma estrutura mais saudável de classes, podemos utilizar o padrão Bridge. É um padrão relativamente complexo, então vale a pena uma leitura com bastante calma: Bridge.

[Title](https://refactoring.guru/design-patterns/bridge)

@@11
Faça como eu fiz

Chegou a hora de você seguir todos os passos realizados por mim durante esta aula. Caso já tenha feito, excelente. Se ainda não, é importante que você execute o que foi visto nos vídeos para poder continuar com a próxima aula.

@@12
O que aprendemos?

Nesta aula, aprendemos:
Como manipular XML com PHP, através da classe SimpleXMLElement
Como criar arquivos ZIP com a classe ZipArchive
A abstrair mais o nosso modelo de classes
Como o padrão Bridge pode nos ajudar a organizar estruturas complexas de classes relacionadas
