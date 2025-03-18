<?php
require __DIR__ . '/../../helpers/posts.php';
require __DIR__ . '/../../fragments/head.html.php';

$post = get_post(__FILE__);
?>

<article id="post">
    <header>
        <h1><?= $post->title ?></h2>
        <h3><?= $post->subtitle ?></h3>
        <aside>Publié le <?= $post->published ?>.</aside>
    </header>

    <div class="post-content">
<h2>Introduction</h2>

<p>
    À des fins d'apprentissage, je souhaite créer un microservice HTTP très simple en Rust.
    Par très simple j'entends : faire du CRUD sur une ressource. Je vais donc écrire ici
    petit à petit mes notes pour mettre en place une API de gestion de doggos. Pourquoi une
    API de gestion de doggos ? <i>Well, because I can</i>.
</p>

<p>
    Le but du jeu est est d'obtenir un service web permettant au minimum d'enregistrer et lire
    des informations sur des doggos à l'aide des routes suivantes :
</p>

<table>
    <thead>
        <tr>
            <th>Méthode</th>
            <th>Chemin</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="mono">POST</td>
            <td class="mono">/doggos</td>
            <td>
                Enregistre les informations sur un doggo,
                passées en JSON dans le corps de la requête.
            </td>
        </tr>
        <tr>
            <td class="mono">GET</td>
            <td class="mono">/doggos/:doggo_id</td>
            <td>
                Récupère les informations sur un doggo.
            </td>
        </tr>
    </tbody>
</table>

<h2>Mise en place du projet</h2>

<p>
    On commence par créer un projet Cargo. Cargo est l'outil de build et de gestion de dépendances fourni
    avec la chaine d'outils de Rust.
</p>

<pre><code class="language-bash"># L'argument `--bin` permet de préciser qu'on souhaite créer un binaire et non une bibliothèque
cargo init --bin doggos

cd doggos
cargo run
</code></pre>

<p>
    Le seul framework web que j'ai déjà un peu pratiqué lors de ma découverte du langage n'étant plus
    maintenu, j'ai choisi d'essayer <a href="https://actix.rs">actix-web</a> qui semble aujourd'hui
    l'un des choix les plus populaires.<br />
    On ajoute donc la dépendance dans le <span class="mono">Cargo.toml</span>, puis on prend le code
    d'exemple. du framework pour transformer notre hello world de la console en hello world over HTTP.
    Voici à quoi ressemble désormais notre <span class="mono">main</span> :
</p>

<pre><code class="language-rust">extern crate actix_web;
use actix_web::{server, App, HttpRequest};

fn index(_req: HttpRequest) -&gt; &'static str {
    "Hello world!"
}

fn main() {
    server::new(|| App::new().resource("/", |r| r.f(index)))
        .bind("127.0.0.1:8088")
        .unwrap()
        .run();
}
</code></pre>

<h2>Des doggos !</h2>

<p>
    Nous allons manipuler des doggos, il est donc temps de définir une structure pour les représenter :
</p>

<pre><code class="language-rust">struct Doggo {
    id: String,
    name: String,
}
</code></pre>

<p>
    Comme discuté dans l'introduction, on souhaite disposer de deux routes différentes. L'une d'entre-elles
    nécessite de parser du JSON représentant un doggo. On ajoute donc en dépendance serde et serde_derive,
    et on dérive le trait <span class="mono">Deserialize</span> sur notre structure :
</p>

<pre><code class="language-rust">#[derive(Deserialize)]
struct Doggo {
// …
</code></pre>

On peut désormais définir nos routes, et dans chacuns de leurs handlers, extraire les informations
nécessaires à leur traitement. Voici à quoi ressemble désormais notre <span class="mono">main.rs</span> :

<pre><code class="language-rust">extern crate actix_web;
#[macro_use] extern crate serde_derive;
use actix_web::{server, http, App, Path, Json};

#[derive(Deserialize)]
struct Doggo {
    id: String,
    name: String,
}

fn register_doggo(doggo: Json&lt;Doggo&gt;) -&gt; String {
    format!("Welcome {}! Good boy.", doggo.name)
}

fn fetch_doggo(path: Path&lt;(String,)&gt;) -&gt; String {
    format!("Hello again, good boy {}!", path.0)
}

fn main() {
    let server = server::new(||
        App::new()
            .resource("/doggos", |r| r.method(http::Method::POST).with(register_doggo))
            .resource("/doggos/{doggo_id}", |r| r.method(http::Method::GET).with(fetch_doggo))
    );

    server.bind("127.0.0.1:8088").unwrap().run();
}
</code></pre>

On peut tester notre serveur web avec les commandes <a href="https://httpie.org/">HTTPie</a> suivantes :
<pre><code class="language-bash"># Register:
http -v POST localhost:8088/doggos &lt;&lt;JSON
{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9",
    "name": "Rantanplan"
}
JSON

# Fetch:
http -v localhost:8088/doggos/963766e8-2b4a-4e4b-a4c6-1e09a16509c9
</code></pre>

On obtient alors les flux HTTP suivants :

<pre><code class="language-http">POST /doggos HTTP/1.1
Accept: application/json
Accept-Encoding: gzip, deflate
Connection: keep-alive
Content-Length: 79
Content-Type: application/json
Host: localhost:8088
User-Agent: HTTPie/0.9.2

{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9", 
    "name": "Rantanplan"
}

HTTP/1.1 200 OK
content-length: 29
content-type: text/plain; charset=utf-8
date: Sun, 22 Jul 2018 07:30:31 GMT

Welcome Rantanplan! Good boy.
</code></pre>

<pre><code class="language-http">GET /doggos/963766e8-2b4a-4e4b-a4c6-1e09a16509c9 HTTP/1.1
Accept: */*
Accept-Encoding: gzip, deflate
Connection: keep-alive
Host: localhost:8088
User-Agent: HTTPie/0.9.2

HTTP/1.1 200 OK
content-length: 59
content-type: text/plain; charset=utf-8
date: Sun, 22 Jul 2018 07:31:00 GMT

Hello again, good boy 963766e8-2b4a-4e4b-a4c6-1e09a16509c9!
</code></pre>

<p>
    Comme vous l'avez remarqué, on n'arrive pas encore vraiment à récupérer les informations
    de notre cher doggo. C'est parce qu'on n'a pas encore de persistance dans notre
    application.
</p>

<h2>Conserver l'état de l'application</h2>

<p>
    Nous allons donc introduire une notion de <i>repository</i> :
</p>

<pre><code class="language-rust">struct InMemoryDoggoRepository {
    map: HashMap&lt;String, Doggo&gt;,
}

impl InMemoryDoggoRepository {
    pub fn new() -&gt; InMemoryDoggoRepository {
        InMemoryDoggoRepository {
            map: HashMap::new(),
        }
    }

    fn save(&mut self, doggo: Doggo) {
        self.map.insert(doggo.id.to_owned(), doggo.to_owned());
    }

    fn find(&self, doggo_id: &String) -&gt; Option&lt;Doggo&gt; {
        match self.map.get(doggo_id) {
            None =&gt; None,
            Some(doggo) =&gt; Some(doggo.to_owned()),
        }
    }
}
</code></pre>

<p>
    La dernière chose dont nous avons besoin pour terminer notre application, c'est de
    pouvoir partager un <i>repository</i> entre nos différents handlers. Nous allons donc créer un
    état pour notre application. Cet état contiendra le <i>repository</i> et nous permettra de
    l'utiliser dans le traitement des différentes requêtes.
</p>

<pre><code class="language-rust">// On définit notre état partagé:
struct AppState {
    repo: InMemoryDoggoRepository,
}

// …

// On initialise l'état partagé lors de la création de l'application:
App::with_state(AppState { repo: InMemoryDoggoRepository::new() }) 
</code></pre>

<p>
    Seulement, cela va malheureusement être un petit peu plus compliqué que cela. En effet,
    le framework traite les requêtes en parallèle dans plusieurs <i>thread</i>. La
    documentation indique d'ailleurs :
</p>

<blockquote cite="https://actix.rs/docs/application/#state">
    Note : le serveur HTTP requiert une <i>factory</i> d'application plutôt qu'une instance d'application.
    Il construit une instance d'application pour chaque <i>thread</i>, ce qui signifie que l'état de l'application
    doit être construit plusieurs fois. Si vous avez besoin de partager l'état entre différents <i>thread</i>,
    il faudra utiliser un objet partagé, par exemple avec le type <span class="mono">Arc</span>.
</blockquote>
<cite>La documentation du framework actix-web, maladroitement traduite par mes soins.</cite>

<p>
    De notre côté, le type <span class="mono">Arc</span> ne suffira pas. Il s'agit en effet d'un type permettant
    de conserver une référence vers un objet avec un système de comptage de références (le « rc » de Arc correspond à
    <i>Reference Counted</i>) compatible avec un environnement concurrent (le « A » de Arc correspond à
    <i>Atomically</i>).<br />
    Notre problème avec <span class="mono">Arc</span> est décrit dès le début de la documentation du type :
</p>

<blockquote cite="https://doc.rust-lang.org/std/sync/struct.Arc.html">
    Par défaut, les références partagées sont immuables en Rust, et <span class="mono">Arc</span> n'y fait pas
    exception : vous ne pouvez pas obtenir une référence modifiable vers les données contenues par un
    <span class="mono">Arc</span>. Si vous avez besoin de modifier à travers un <span class="mono">Arc</span>,
    utilisez <span class="mono">Mutex</span>, <span class="mono">RwLock</span>, ou un des types
    <span class="mono">Atomic</span>.
</blockquote>
<cite>La documentation du type <span class="mono">Arc</span>, maladroitement traduite par mes soins.</cite>

<p>
    Je passe sur les types atomiques, qui ne me semblent pas adaptés.
    Nous avons donc le choix entre utiliser un Mutex, qui permet de n'accéder aux données qu'après avoir obtenu
    un verrou, ou bien un RwLock. Nous allons choisir cette dernière solution, qui est similaire à un Mutex mais
    qui permet de distinguer les verrous en lecture et en écriture. C'est pertinent dans notre cas où nous avons
    un handler qui va écrire des données, et un autre qui ne fera que lire : inutile de bloquer l'accès aux
    données dans les moments où nous ne faisons que de la lecture.<br />
    Toutefois, un RwLock ne suffit pas ! Il permet bel et bien de partager les données de façon sûre, mais il
    doit lui-même être partagé entre plusieurs threads. Pour cela on peut en revanche utiliser un Arc. Voici
    le code complet de notre <span class="mono">main.rs</span> une fois que c'est fait :
</p>

<pre><code class="language-rust">extern crate actix_web;
#[macro_use] extern crate serde_derive;

use actix_web::{server, http, HttpResponse, Responder, App, State, Path, Json};
use std::collections::HashMap;
use std::sync::{Arc, RwLock};

#[derive(Clone,Deserialize)]
struct Doggo {
    id: String,
    name: String,
}

struct InMemoryDoggoRepository {
    map: HashMap&lt;String, Doggo&gt;,
}

impl InMemoryDoggoRepository {
    pub fn new() -&gt; InMemoryDoggoRepository {
        InMemoryDoggoRepository {
            map: HashMap::new(),
        }
    }

    fn save(&mut self, doggo: Doggo) {
        self.map.insert(doggo.id.to_owned(), doggo.to_owned());
    }

    fn find(&self, doggo_id: &String) -&gt; Option&lt;Doggo&gt; {
        match self.map.get(doggo_id) {
            None =&gt; None,
            Some(doggo) =&gt; Some(doggo.to_owned()),
        }
    }
}

struct AppState {
    locked_repo: Arc&lt;RwLock&lt;InMemoryDoggoRepository&gt;&gt;,
}

fn register_doggo((state, json_doggo): (State&lt;AppState&gt;, Json&lt;Doggo&gt;)) -&gt; impl Responder {
    let mut repo = state.locked_repo.write().unwrap();

    repo.save(json_doggo.into_inner().to_owned());

    HttpResponse::Ok()
}

fn fetch_doggo((state, path) : (State&lt;AppState&gt;, Path&lt;(String,)&gt;)) -&gt; impl Responder {
    let repo = state.locked_repo.read().unwrap();

    match repo.find(&path.0) {
        None =&gt; HttpResponse::NotFound().body("oops"),
        Some(doggo) =&gt; HttpResponse::Ok().body(doggo.name),
    }
}

fn main() {
    let locked_repo = Arc::new(RwLock::new(InMemoryDoggoRepository::new()));

    let server = server::new(move ||
        App::with_state(AppState { locked_repo: Arc::clone(&locked_repo) })
            .resource("/doggos", |r| r.method(http::Method::POST).with(register_doggo))
            .resource("/doggos/{doggo_id}", |r| r.method(http::Method::GET).with(fetch_doggo))
    );

    server.bind("127.0.0.1:8088").unwrap().run();
}
</code></pre>

<h2>Finitions</h2>

<p>
    En dérivant le <span class="mono">trait</span> <span class="mono">Serialize</span> en plus de
    <span class="mono">Deserialize</span>, on peut facilement renvoyer du JSON dans les reponses. <br />
</p>

<h2>Résultat</h2>

<p>
    Le code complet est disponible <a href="https://github.com/cGuille/doggos">sur GitHub</a>.
</p>

<p>
    On peut tester un worflow d'appels d'API :
</p>

<pre><code class="language-bash"># On essaie de récupérer un doggo qui n'existe pas:
http -v localhost:8088/doggos/963766e8-2b4a-4e4b-a4c6-1e09a16509c9

# Ensuite on enregistre un doggo:
http -v POST localhost:8088/doggos &lt;&lt;JSON
{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9",
    "name": "Rantanplan"
}
JSON

# On récupère ses infos:
http -v localhost:8088/doggos/963766e8-2b4a-4e4b-a4c6-1e09a16509c9

# On modifie notre doggo:
http -v POST localhost:8088/doggos &lt;&lt;JSON
{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9",
    "name": "Rantanplan, good boy"
}
JSON

# Puis on vérifie que ses infos on bien été mises à jour:
http -v localhost:8088/doggos/963766e8-2b4a-4e4b-a4c6-1e09a16509c9
</code></pre>

<p>
    Voici les flux HTTP correspondant :
</p>

<pre><code class="language-http">GET /doggos/963766e8-2b4a-4e4b-a4c6-1e09a16509c9 HTTP/1.1
Accept: */*
Accept-Encoding: gzip, deflate
Connection: keep-alive
Host: localhost:8088
User-Agent: HTTPie/0.9.2

HTTP/1.1 404 Not Found
content-length: 0
date: Sun, 22 Jul 2018 10:06:54 GMT
</code></pre>

<pre><code class="language-http">POST /doggos HTTP/1.1
Accept: application/json
Accept-Encoding: gzip, deflate
Connection: keep-alive
Content-Length: 79
Content-Type: application/json
Host: localhost:8088
User-Agent: HTTPie/0.9.2

{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9",
    "name": "Rantanplan"
}

HTTP/1.1 200 OK
content-length: 65
content-type: application/json
date: Sun, 22 Jul 2018 10:07:51 GMT

{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9",
    "name": "Rantanplan"
}
</code></pre>

<pre><code class="language-http">GET /doggos/963766e8-2b4a-4e4b-a4c6-1e09a16509c9 HTTP/1.1
Accept: */*
Accept-Encoding: gzip, deflate
Connection: keep-alive
Host: localhost:8088
User-Agent: HTTPie/0.9.2

HTTP/1.1 200 OK
content-length: 65
content-type: application/json
date: Sun, 22 Jul 2018 10:08:19 GMT

{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9",
    "name": "Rantanplan"
}
</code></pre>

<pre><code class="language-http">POST /doggos HTTP/1.1
Accept: application/json
Accept-Encoding: gzip, deflate
Connection: keep-alive
Content-Length: 89
Content-Type: application/json
Host: localhost:8088
User-Agent: HTTPie/0.9.2

{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9",
    "name": "Rantanplan, good boy"
}

HTTP/1.1 200 OK
content-length: 75
content-type: application/json
date: Sun, 22 Jul 2018 10:08:50 GMT

{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9",
    "name": "Rantanplan, good boy"
}
</code></pre>

<pre><code class="language-http">GET /doggos/963766e8-2b4a-4e4b-a4c6-1e09a16509c9 HTTP/1.1
Accept: */*
Accept-Encoding: gzip, deflate
Connection: keep-alive
Host: localhost:8088
User-Agent: HTTPie/0.9.2

HTTP/1.1 200 OK
content-length: 75
content-type: application/json
date: Sun, 22 Jul 2018 10:09:06 GMT

{
    "id": "963766e8-2b4a-4e4b-a4c6-1e09a16509c9",
    "name": "Rantanplan, good boy"
}
</code></pre>
    </div>
    
    <aside>
        <p><a href="/" class="return-link">Retour</a></p>
    </aside>

    <footer>Vous avez vraiment tout lu ? Bravo ! <a href="#">↑ Vous pouvez remonter maintenant ↑</a>.</footer>
</article>

<?php require __DIR__ . '/../../fragments/foot.html.php'; ?>
