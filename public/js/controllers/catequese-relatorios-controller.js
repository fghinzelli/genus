'use strict';


angular.module('Home',)
.controller('RelatoriosController',
    ['$rootScope', '$scope', '$http', '$cookieStore', '$routeParams', '$window',
    function ($rootScope, $scope, $http, $cookieStore, $routeParams, $window) {
        
        var serviceBase = 'services/relatorios/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];

        $scope.imprimir = function(report_name) {
            $http.get(serviceBase +  report_name)
            .success(function(dados) {
                var grid = getColumns(report_name, dados);
                var doc = new jsPDF("landscape");
                doc.text(grid[0], 14, 16);
                //var elem = document.getElementById("table-report");
                //var res = doc.autoTableHtmlToJson(elem);
                doc.autoTable(grid[1], grid[2], {startY: 20});
                doc.save('table.pdf');
            })
            .error(function(erro) {
                console.log(erro);
            });

            //var columns = ["ID", "Name", "Country"];

            
            
        }
        
    }]);

function getColumns(report_name, dados) {
    var columns = [];
    var rows = [];
    var title = '';
    switch (report_name) {
        case 'catequizandos-etapas':
            title = 'Catequizandos por Etapa'
            columns = ["Etapa", "Comunidade", "Nome"];
            for (var i=0; i<dados.length; i++) {
                rows.push([dados[i].inscricaoCatequese.etapaCatequese.descricao,
                           dados[i].inscricaoCatequese.comunidade.nome,
                           dados[i].inscricaoCatequese.pessoa.nome
                          ])
            }
            return [title, columns, rows];
            break;
        case 'catequizandos-turmas':
            title = 'Catequizandos por Turma'
            columns = ["Comunidade", "Etapa", "Dia da Semana", "Horário", "Catequista", "Nome"];
            for (var i=0; i<dados.length; i++) {
                rows.push([dados[i].inscricaoCatequese.comunidade.nome,
                           dados[i].inscricaoCatequese.etapaCatequese.descricao,
                           dados[i].turmaCatequese.diaSemana,
                           dados[i].turmaCatequese.horario,
                           dados[i].turmaCatequese.catequista.pessoa.nome,
                           dados[i].inscricaoCatequese.pessoa.nome
                          ])
            }
            return [title, columns, rows];
            break;
        case 'catequizandos-padrinhos':
            title = 'Padrinhos dos Catequizandos da Crisma'
            columns = ["Comunidade", "Catequista", "Nome", "Padrinho"];
            for (var i=0; i<dados.length; i++) {
                rows.push([dados[i].inscricaoCatequese.comunidade.nome,
                           dados[i].turmaCatequese.catequista.pessoa.nome,
                           dados[i].inscricaoCatequese.pessoa.nome,
                           dados[i].inscricaoCatequese.nomePadrinho
                          ])
            }
            return [title, columns, rows];
            break;
        case 'turmas-comunidade':
            title = 'Turmas por Comunidade'
            columns = ["Comunidade", "Etapa", "Dia da Semana", "Turno", "Horário", "Catequista"];
            for (var i=0; i<dados.length; i++) {
                rows.push([dados[i].comunidade.nome,
                           dados[i].etapaCatequese.descricao,
                           dados[i].diaSemana,
                           dados[i].turno.descricao,
                           dados[i].horario,
                           dados[i].catequista.pessoa.nome,
                          ])
            }
            return [title, columns, rows];
            break;
        case 'catequistas-comunidade':
            title = 'Catequistas por Comunidade'
            console.log('catequistas-comunidade')
            break;
        default:
            break;
    }
        

}