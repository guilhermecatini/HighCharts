<?php
// Routes



$app->get('/dados', function ($req, $res) {

  $query = "SELECT to_char(vnd_orcamento.data_emissao, 'YYYY') AS ano,
                           cli_endereco.uf AS uf, 
                           sum(vnd_orcamento.vlr_total_liquido) AS total
                           
                           
                      FROM cli_endereco

                      JOIN vnd_orcamento
                        ON vnd_orcamento.cliente = cli_endereco.cliente

                    WHERE LENGTH(cli_endereco.uf) = 2
                      AND cli_endereco.uf != '  '
                      AND vnd_orcamento.situacao = 'A'
                    GROUP BY cli_endereco.uf,
                             to_char(vnd_orcamento.data_emissao, 'YYYY')

                    HAVING to_char(vnd_orcamento.data_emissao, 'YYYY') = '2017'

                    ORDER BY 1, 3 desc";

  $result = $this->db->prepare($query);
  $result->execute();

  return $res->withJson($result->fetchAll(\PDO::FETCH_ASSOC), 200);
});

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});