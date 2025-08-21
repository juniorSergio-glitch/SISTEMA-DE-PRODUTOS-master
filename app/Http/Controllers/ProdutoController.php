<?php

class ProdutoController
{
    private $produtos = [];
    private $dbFile;
    
    public function __construct()
    {
        $this->dbFile = __DIR__ . '/../../../storage/produtos.json';
        $this->carregarProdutos();
    }
    
    private function carregarProdutos()
    {
        if (file_exists($this->dbFile)) {
            $this->produtos = json_decode(file_get_contents($this->dbFile), true) ?: [];
        }
    }
    
    private function salvarProdutos()
    {
        file_put_contents($this->dbFile, json_encode($this->produtos, JSON_PRETTY_PRINT));
    }
    
    public function index()
    {
        $produtos = $this->produtos;
        include __DIR__ . '/../../../resources/views/produtos/index.php';
    }
    
    public function create()
    {
        include __DIR__ . '/../../../resources/views/produtos/create.php';
    }
    
    public function store()
    {
        $dados = [
            'id' => count($this->produtos) + 1,
            'nome' => $_POST['nome'] ?? '',
            'descricao' => $_POST['descricao'] ?? '',
            'preco' => floatval($_POST['preco'] ?? 0),
            'categoria' => $_POST['categoria'] ?? '',
            'estoque' => intval($_POST['estoque'] ?? 0),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->produtos[] = $dados;
        $this->salvarProdutos();
        
        $_SESSION['success'] = 'Produto criado com sucesso!';
        redirect('/');
    }
    
    public function show($id)
    {
        $produto = $this->encontrarProduto($id);
        if (!$produto) {
            $_SESSION['error'] = 'Produto não encontrado!';
            redirect('/');
            return;
        }
        
        include __DIR__ . '/../../../resources/views/produtos/show.php';
    }
    
    public function edit($id)
    {
        $produto = $this->encontrarProduto($id);
        if (!$produto) {
            $_SESSION['error'] = 'Produto não encontrado!';
            redirect('/');
            return;
        }
        
        include __DIR__ . '/../../../resources/views/produtos/edit.php';
    }
    
    public function update($id)
    {
        $index = $this->encontrarIndiceProduto($id);
        if ($index === false) {
            $_SESSION['error'] = 'Produto não encontrado!';
            redirect('/');
        }
        
        $this->produtos[$index] = array_merge($this->produtos[$index], [
            'nome' => $_POST['nome'] ?? $this->produtos[$index]['nome'],
            'descricao' => $_POST['descricao'] ?? $this->produtos[$index]['descricao'],
            'preco' => floatval($_POST['preco'] ?? $this->produtos[$index]['preco']),
            'categoria' => $_POST['categoria'] ?? $this->produtos[$index]['categoria'],
            'estoque' => intval($_POST['estoque'] ?? $this->produtos[$index]['estoque']),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->salvarProdutos();
        
        $_SESSION['success'] = 'Produto atualizado com sucesso!';
        redirect('/');
    }
    
    public function destroy($id)
    {
        $index = $this->encontrarIndiceProduto($id);
        if ($index === false) {
            $_SESSION['error'] = 'Produto não encontrado!';
            redirect('/');
        }
        
        array_splice($this->produtos, $index, 1);
        $this->salvarProdutos();
        
        $_SESSION['success'] = 'Produto excluído com sucesso!';
        redirect('/');
    }
    
    private function encontrarProduto($id)
    {
        foreach ($this->produtos as $produto) {
            if ($produto['id'] == $id) {
                return $produto;
            }
        }
        return null;
    }
    
    private function encontrarIndiceProduto($id)
    {
        foreach ($this->produtos as $index => $produto) {
            if ($produto['id'] == $id) {
                return $index;
            }
        }
        return false;
    }
}