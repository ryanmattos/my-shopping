<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/shopping-style.css">
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
                <div class="shopping-list" id="app-list">
                    <form action="finish.php" method="get">
                        <input type="hidden" name="balance"  id="hidden__balance" style="display: none">
                        <input type="hidden" name="final-price" id="hidden__final-price" style="display: none">
                        <div class="sl-header">
                            <div class="content">
                                <p class="title">Lista de compras</p>
                                <p class="subtitle">Adicione o valor e a quantidade de cada produto que comprar</p>
                            </div>
                        </div>
                        <div class="sl-body" id="sl__body">
                            <?php
                                for($i = 1; $i < count($_GET); $i++){
                                    if($_GET[$i] !== ""){
                                    ?>
                                        <div class="sl-input-field" id="box-item-<?php echo $i; ?>">
                                            <span class="product-name"><?php echo $_GET[$i]; ?></span>
                                            <input type="hidden" name="product-name-<?php echo $i ?>" style="display: none" value="<?php echo $_GET[$i] ?>">
                                            <input type="hidden" name="is-extra-<?php echo $i ?>" style="display: none" value="0">
                                            <input type="number" onchange="countValue(this)" name="product-quant-<?php echo $i ?>" id="quant-item-<?php echo $i; ?>" class="input-item quant-input" value="1">
                                            <input type="text" onkeyup="checkInput(this);currencyChecker(this)" onchange="countValue(this)" name="product-price-<?php echo $i ?>" id="input-item-<?php echo $i; ?>" class="input-item price-input">
                                            <span class="placeholder-text" onclick="inputFocus(this)">valor</span>
                                        </div>
                                    <?php
                                    }
                                }
                            ?>
                        </div>
                        <div class="sl-input-field" style="text-align: center;margin-bottom: 10px;height: 15px">
                            <span id="add_extra-item" class="__extra-item" onclick="toggleAddItemModal(true)">Adicionar item extra</span>
                        </div>
                        <div class="sl-footer">
                            <div class="sl-box">
                                <button id="go-shopping" type="submit">Finalizar compras</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="app-footer" id="app-footer">
                <div class="desc-list">
                    <div class="dl-header" ontouchmove="showDetails(x)">
                        <div class="dl-right-content">
                            <div class="top-side">
                                <span class="title">Valor da compra</span>
                                <p class="subtitle">R$<span id="money" onchange="checkCurrency(this)"> 0.00</span></p>
                            </div>
                            <div class="bottom-side">
                                <span class="title">Saldo</span>
                                <span class="subtitle" id="dl__balance">R$<span id="balance"><?php echo $_GET['sl__value']; ?></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="dl-body">
                        <div class="product-list">
                            <span class="list-title">Produtos da lista</span>
                            <div class="row">
                                <?php
                                    for($i = 1; $i < count($_GET); $i++){
                                        if($_GET[$i] !== ""){
                                        ?> 
                                            <div class="product">
                                                <div class="left"><span class="product-name" id="product-name-<?php echo $i; ?>"><?php echo $_GET[$i]; ?></span></div>
                                                <div class="right">
                                                    <span id="product-quant-<?php echo $i; ?>">1</span> x
                                                    <span class="pr-subtitle">R$ <span class="product-price" id="product-price-<?php echo $i; ?>">---</span></span>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    
                                ?>
                            </div>
                        </div>
                        <div class="extra-list" id="--extra__list">
                            <span class="list-title" style="width:69px;">Produtos extras</span>
                            <div class="row" id="extra__list">
                                
                            </div>
                        </div>
                    </div>
                    <div class="dl-footer"></div>
                </div>
                <div class="swipe-box">
                    <button class="swipe-button" id="swp-btn" onclick="showDetails(this)">
                        <img src="../resources/images/arrow.gif" height="30" width="30" alt="">
                    </button>
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
