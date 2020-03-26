<?php
    // echo count($_GET)/4;

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/shopping-style.css">
    <link rel="stylesheet" href="../resources/css/finish-style.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Lexend+Deca&display=swap" rel="stylesheet"> -->
    <title>Shopping List</title>
</head>
<body onload="adjustPosition()">
    <div class="app">
        <div class="background-blured" id="app-background"></div>
        <div class="screen-fix">
            <div class="app-navbar" id="app-navbar">
                MyShopping
            </div>
            <div class="app-body">
                <div class="shopping-list">
                    <div class="sl-header">
                        <div class="content">
                            <p class="title">Resumo da compra</p>
                            <p class="subtitle">Veja o resumo detalhado da sua compra.</p>
                        </div>
                    </div>
                    <div class="sl-body">
                            <div class="resume-list">
                                <div class="resume-container">
                                    <div class="rl-header">
                                        <span class="title">Seu saldo</span>
                                        <p class="subtitle">O status do seu saldo após sua compra.</p>
                                    </div>
                                    <div class="rl-body">
                                        <div class="product">
                                            <div class="left"><span style="font-size:15px;color:gray">Saldo inicial</span></div>
                                            <div class="right"><span class="pr-subtitle">R$ <?php echo $_GET['balance']; ?></span></div>
                                        </div>
                                        <div class="product">
                                            <div class="left"><span style="font-size:15px;color:gray">Valor da compra</span></div>
                                            <div class="right"><span class="pr-subtitle">R$ <?php echo $_GET['final-price']; ?></span></div>
                                        </div>
                                        <div class="product">
                                            <div class="left"><span style="font-size:15px;color:gray">Saldo final</span></div>
                                            <div class="right"><span class="pr-subtitle <?php if($_GET['balance'] - $_GET['final-price'] > 0) echo "underbalance"; else echo "overbalance"?>">R$ <?php echo $_GET['balance'] - $_GET['final-price']; ?></span></div>
                                        </div>
                                        <?php
                                            if($_GET['balance'] - $_GET['final-price'] > 0){
                                        ?>
                                            <p style="font-size:13px;color:gray;text-align:center;margin-top:0px;">Você economizou R$ <?php echo $_GET['balance'] - $_GET['final-price']; ?>, parabéns! ;)</p>
                                        <?php
                                            } else {
                                        ?>
                                            <p style="font-size:13px;color:gray;text-align:center;margin-top:0px;">Você teve que tirar R$ <?php echo ($_GET['balance'] - $_GET['final-price'])*-1; ?> a mais da carteira ;(</p>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="resume-container">
                                    <div class="rl-header">
                                        <span class="title">Produtos da lista</span>
                                        <p class="subtitle">Estes são os produtos que você inseriu na sua lista antes de ir às compras.</p>
                                    </div>
                                    <div class="rl-body">
                                        <?php 
                                            $extra = false;
                                            for($i = 1; $i <= (count($_GET) - 2)/4; $i++){
                                                if($_GET['is-extra-'.$i] == 0){
                                                ?>
                                                    <div class="product">
                                                        <div class="left"><span class="product-name" id="product-name-<?php echo $i; ?>"><?php echo $_GET['product-name-'.$i]; ?></span></div>
                                                        <div class="right">
                                                            <span id="product-quant-<?php echo $i; ?>"><?php echo $_GET['product-quant-'.$i] ?></span> x
                                                            <span class="pr-subtitle">R$ <span class="product-price" id="product-price-<?php echo $i; ?>"><?php echo $_GET['product-price-'.$i]; ?></span></span>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                    $extra = true;
                                                }
                                            }
                                            
                                        ?>
                                    </div>
                                </div>
                                <?php
                                    if($extra){
                                ?>
                                    <div class="resume-container">
                                        <div class="rl-header">
                                            <span class="title">Produtos extras</span>
                                            <p class="subtitle">Estes são os produtos que você inseriu na sua lista enquanto você estava fazendo compras.</p>
                                        </div>
                                        <div class="rl-body">
                                            <?php 
                                                for($i = 1; $i <= (count($_GET) - 2)/4; $i++){
                                                    if($_GET['is-extra-'.$i] == 1){
                                                    ?>
                                                        <div class="product extra">
                                                            <div class="left"><span class="product-name" id="product-name-<?php echo $i; ?>"><?php echo $_GET['product-name-'.$i]; ?></span></div>
                                                            <div class="right">
                                                                <span id="product-quant-<?php echo $i; ?>"><?php echo $_GET['product-quant-'.$i] ?></span> x
                                                                <span class="pr-subtitle">R$ <span class="product-price" id="product-price-<?php echo $i; ?>"><?php echo $_GET['product-price-'.$i]; ?></span></span>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                                <div class="resume-container">
                                    <div class="rl-header">
                                        <span class="title">Caro demais!</span>
                                        <p class="subtitle">O top 3 dos produtos mais caros da sua compra.</p>
                                    </div>
                                    <div class="rl-body">
                                        <?php 
                                            $expensive = array();
                                            
                                            for($i = 1; $i <= (count($_GET) - 2)/4; $i++){
                                                array_push($expensive,  $_GET['product-price-'.$i].':'.$i);
                                            }
                                            rsort($expensive);
                                            // if(count($expensive) > 3)
                                            //     array_slice($expensive, 0, 3);
                                            for($i = 0; $i < count(array_slice($expensive, 0, 3)); $i++){
                                                $exploded = explode(':', $expensive[$i]);
                                                // echo $exploded[1];
                                                ?>
                                                    <div class="product <?php if($_GET['is-extra-'.$exploded[1]] == 1) echo "extra"; ?>">
                                                        <div class="left"><span class="product-name" id="product-name-<?php echo $exploded[1]; ?>"><?php echo $_GET['product-name-'.$exploded[1]]; ?></span></div>
                                                        <div class="right">
                                                            <span id="product-quant-<?php echo $i; ?>"><?php echo $_GET['product-quant-'.$exploded[1]] ?></span> x
                                                            <span class="pr-subtitle">R$ <span class="product-price" id="product-price-<?php echo $exploded[1]; ?>"><?php echo $_GET['product-price-'.$exploded[1]]; ?></span></span>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="resume-container">
                                    <div class="rl-header">
                                        <span class="title">Baratinho!</span>
                                        <p class="subtitle">O top 3 dos produtos mais baratos da sua compra.</p>
                                    </div>
                                    <div class="rl-body">
                                        <?php 
                                            $expensive = array();
                                            
                                            for($i = 1; $i <= (count($_GET) - 2)/4; $i++){
                                                array_push($expensive,  $_GET['product-price-'.$i].':'.$i);
                                            }
                                            sort($expensive);
                                            for($i = 0; $i < count(array_slice($expensive, 0, 3)); $i++){
                                                $exploded = explode(':', $expensive[$i]);
                                                // echo $exploded[1];
                                                ?>
                                                    <div class="product <?php if($_GET['is-extra-'.$exploded[1]] == 1) echo "extra"; ?>">
                                                        <div class="left"><span class="product-name" id="product-name-<?php echo $exploded[1]; ?>"><?php echo $_GET['product-name-'.$exploded[1]]; ?></span></div>
                                                        <div class="right">
                                                            <span id="product-quant-<?php echo $i; ?>"><?php echo $_GET['product-quant-'.$exploded[1]] ?></span> x
                                                            <span class="pr-subtitle">R$ <span class="product-price" id="product-price-<?php echo $exploded[1]; ?>"><?php echo $_GET['product-price-'.$exploded[1]]; ?></span></span>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sl-footer">
                            <div class="sl-box">
                                <button id="go-shopping" type="button">Voltar para o início</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="asking-modal" id="modal__add-item">
        <div class="asking-modal-box">
            <div class="am-header">
                <p class="title">Adicionar novo item</p>
                <span class="close" id="close" onclick="toggleAddItemModal(false);">&times;</span>
            </div>
            <div class="am-body">
                <div class="am-body-helper">
                    <div class="bottom">
                        <div class="sl-input-field">
                            <input type="text" autocomplete="off" onkeyup="checkInput(this)" id="input_add-item" class="input-item am-add-input">
                            <span class="placeholder-text am-add-placeholder" onclick="inputFocus(this)">Adicione um item extra</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="am-footer">
                <div class="cancel-button">
                    <button id="close-modal" type="button" onclick="toggleAddItemModal(false);">Cancelar</button>
                </div>
                <div class="shopping-button">
                    <button id="go-shopping" onclick="addItem()">Adicionar item</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="resources/js/script.js"></script>
