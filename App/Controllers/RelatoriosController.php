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
    }