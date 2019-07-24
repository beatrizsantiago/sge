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
                    "Attachment" => false /* Para download, altere para true */
                )
            );
        }

        public function listaPresenca() {
            $listarInscritos = Container::getModel('InscricaoAtividade');
            $listarInscritos->__set('id', base64_decode($_GET['idAtv']));

            $listaPresenca = $listarInscritos->listarInscritos();

            $dompdf = new Dompdf();

            $html = '
                <!DOCTYPE html>
                <html lang="pt-br">
                <head>
                    <meta charset="UTF-8">
                    <title>Relatorio Evento</title>

                    <style>
                        .table {
                            width: 100%;
                        }
                        .head-table {
                            background-color: #cecece;
                        }

                        .big-field {
                            width: 40%;
                            border-right: solid 1px #9b9b9b;
                        }
                        .small-field {
                            width: 20%;
                        }

                        td {
                            border-bottom: solid 1px #9b9b9b;
                            padding: 12px 4px 5px 4px;
                            font-size: 20px;
                        }
                        
                    </style>
                </head>
                <body>
                    <table class="table" cellspacing="0px">
                        <thead class="head-table">
                            <th class="big-field">Nome</th>
                            <th class="big-field">Assinatura</th>
                            <th class="small-field">Matrícula</th>
                        </thead>
                        <tbody> 
            ';

                            foreach ($listaPresenca as $value) {
                                $html .= '
                                <tr>
                                    <td class="big-field">' . $value['nome'] . '</td>
                                    <td class="big-field"></td>
                                    <td class="small-field"></td>
                                </tr>';
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
                    "Attachment" => false /* Para download, altere para true */
                )
            );

        }
    }