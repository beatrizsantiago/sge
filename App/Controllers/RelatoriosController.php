<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;
    use Dompdf\Dompdf;

    class RelatoriosController extends Action {

        public function relatorioEvento() {

            $eventoID = base64_decode($_GET['idEvt']);

            $listaAtividade = Container::getModel('Atividade');
            $listaAtividade->__set('eventoID', $eventoID);

            $relatorio = $listaAtividade->listarAtividades();

            $dompdf = new Dompdf();

            $html = '
                <!doctype html> 
                <html> 
                    <head>
                    </head>

                    <body>
                        <div>
            ';
                        foreach ($relatorio as $value) {
                            $html .= '<h1"> ' . $value['tema'] . ' </h1>';
                        }

            $html .='
                        </div>
                    </body> 
                </html>
            ';

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream(
                "relatorio-evento.pdf",
                array(
                    "Attachment" => false 
                )
            );
        }

        public function listaPresenca() {
            $listarInscritos = Container::getModel('InscricaoAtividade');
            $listarInscritos->__set('id', base64_decode($_GET['idAtv']));
            
            $listaPresenca = $listarInscritos->listarInscritos();

            $dadosAtividade = Container::getModel('Atividade');
            $dadosAtividade->__set('id', base64_decode($_GET['idAtv']));

            $dados = $dadosAtividade->getNomeAtividade();

            $dompdf = new Dompdf();

            $html = '
                <!DOCTYPE html>
                <html lang="pt-br">
                <head>
                    <meta charset="UTF-8">
                    <title>Lista Presença</title>

                    <style>
                        .table {
                            width: 1400px;
                        }
                        .head-table {
                            background-color: #e8e8e8;
                            text-align: center;
                            font-family: sans-serif;
                            font-weight: bold;
                        }

                        .big-field {
                            width: 40%;
                            border-right: solid 1px #bfbfbf;
                        }
                        .small-field {
                            width: 20%;
                        }

                        h1 {
                            text-align: center;
                            font-family: sans-serif;
                            font-size: 20px;
                        }

                        td {
                            border-bottom: solid 1px #bfbfbf;
                            padding: 10px 4px 5px 4px;
                            font-size: 16px;
                        }
                        
                    </style>
                </head>
                <body>
                    <h1>Lista de Presença - ' . $dados['tipo'] . ' ' . $dados['tema'] . ' </h1>
                    <table class="table" cellspacing="0px">
                        <thead class="head-table">
                            <th class="big-field">Nome</th>
                            <th class="big-field">Assinatura</th>
                            <th class="small-field">Matrícula</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="big-field"></td>
                                <td class="big-field"></td>
                                <td class="small-field"></td>
                            </tr>
            ';

                            foreach ($listaPresenca as $value) {
                                for ($li = count($listaPresenca) - 1; $li < count($listaPresenca); $li++) {
                                    $html .= '
                                    <tr>
                                        <td class="big-field">' . $value['nome'] . '</td>
                                        <td class="big-field"></td>
                                        <td class="small-field"></td>
                                    </tr>';
                                }
                            }

            $html .= '                
                        </tbody>
                    </table>
                </body>
                </html>
            ';

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream(
                "lista-presenca.pdf",
                array(
                    "Attachment" => false
                )
            );

        }
    }