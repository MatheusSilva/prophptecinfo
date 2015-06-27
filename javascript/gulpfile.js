var js1  = [
    '/var/www/sistemaRest/javascript/jquery-2.1.4.min.js'
    ,'/var/www/sistemaRest/javascript/crypto.js'
];

var js2  = [
    ,'/var/www/sistemaRest/javascript/valida_login.js'
    ,'/var/www/sistemaRest/javascript/categoria.js'
];

var js3  = [
    ,'/var/www/sistemaRest/javascript/valida_login.js'
    ,'/var/www/sistemaRest/javascript/divisao.js'
];

var js4  = [
    ,'/var/www/sistemaRest/javascript/valida_login.js'
    ,'/var/www/sistemaRest/javascript/time.js'
];

var js5  = [
    ,'/var/www/sistemaRest/javascript/valida_login.js'
    ,'/var/www/sistemaRest/javascript/tecnico.js'
];

var js7  = [
    ,'/var/www/sistemaRest/javascript/valida_login.js'
];

var js6  = [
    '/var/www/sistemaRest/javascript/script1.min.js'
    ,'/var/www/sistemaRest/javascript/script2.min.js'
];

// Núcleo do Gulp
var gulp = require('gulp');
 
// Transforma o javascript em formato ilegível para humanos
var uglify = require("gulp-uglify");
 
// Agrupa todos os arquivos em um
var concat = require("gulp-concat");
 
// Tarefa de minificação do Javascript
gulp.task('minify-js', function () {
    gulp.src(js1)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('script1.min.js'))      // Arquivo único de saída
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});
 
gulp.task('minify-jsCategoria', function () {
    gulp.src(js2)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('script2.min.js'))      // Arquivo único de saída
    .pipe(uglify())                     // Transforma para formato ilegível
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

gulp.task('minify-jsFinalCategoria', function () {
    gulp.src(js6)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('categoria.min.js'))      // Arquivo único de saída
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

gulp.task('minify-jsDivisao', function () {
    gulp.src(js3)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('script2.min.js'))      // Arquivo único de saída
    .pipe(uglify())                     // Transforma para formato ilegível
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

gulp.task('minify-jsFinalDivisao', function () {
    gulp.src(js6)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('divisao.min.js'))      // Arquivo único de saída
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

gulp.task('minify-jsTime', function () {
    gulp.src(js4)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('script2.min.js'))      // Arquivo único de saída
    .pipe(uglify())                     // Transforma para formato ilegível
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

gulp.task('minify-jsFinalTime', function () {
    gulp.src(js6)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('time.min.js'))      // Arquivo único de saída
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

gulp.task('minify-jsTecnico', function () {
    gulp.src(js5)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('script2.min.js'))      // Arquivo único de saída
    .pipe(uglify())                     // Transforma para formato ilegível
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

gulp.task('minify-jsFinalTecnico', function () {
    gulp.src(js6)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('tecnico.min.js'))      // Arquivo único de saída
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

gulp.task('minify-jsLogin', function () {
    gulp.src(js7)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('script2.min.js'))      // Arquivo único de saída
    .pipe(uglify())                     // Transforma para formato ilegível
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

gulp.task('minify-jsFinalLogin', function () {
    gulp.src(js6)                        // Arquivos que serão carregados, veja variável 'js' no início
    .pipe(concat('login.min.js'))      // Arquivo único de saída
    .pipe(gulp.dest('/var/www/sistemaRest/javascript/'));          // pasta de destino do arquivo(s)
});

var del = require('del');

gulp.task('limpa', function (cb) {
  del(js6, cb);
});

// Tarefa padrão quando executado o comando GULP

gulp.task('categoria',['minify-js','minify-jsCategoria']);
gulp.task('categoriafinal',['minify-jsFinalCategoria']);

gulp.task('divisao',['minify-js','minify-jsDivisao']);
gulp.task('divisaofinal',['minify-jsFinalDivisao']);

gulp.task('time',['minify-js','minify-jsTime']);
gulp.task('timefinal',['minify-jsFinalTime']);

gulp.task('tecnico',['minify-js','minify-jsTecnico']);
gulp.task('tecnicofinal',['minify-jsFinalTecnico']);

gulp.task('login',['minify-js','minify-jsLogin']);
gulp.task('loginfinal',['minify-jsFinalLogin']);

gulp.task('limpar',['limpa']);

// Tarefa de monitoração caso algum arquivo seja modificado, deve ser executado e deixado aberto, comando "gulp watch".
gulp.task('watch', function() {
    gulp.watch(js1, ['minify-js']);
    
    gulp.watch(js2, ['minify-jsCategoria']);
    gulp.watch(js6, ['minify-jsFinalCategoria']);
    
    gulp.watch(js3, ['minify-jsDivisao']);
    gulp.watch(js6, ['minify-jsFinalDivisao']);
    
    gulp.watch(js4, ['minify-jsTime']);
    gulp.watch(js6, ['minify-jsFinalTime']);
    
    gulp.watch(js5, ['minify-jsTecnico']);
    gulp.watch(js6, ['minify-jsFinalTecnico']);
    
    gulp.watch(js7, ['minify-jsLogin']);
    gulp.watch(js6, ['minify-jsFinalLogin']);
    
    gulp.watch(js6, ['limpa']);
});
