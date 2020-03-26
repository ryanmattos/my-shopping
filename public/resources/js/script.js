//login twitter api
document.getElementById('tt__log').onclick = function(){
    Location('header: https://api.twitter.com/oauth2/token?grant_type=client_credentials');
}

//Function that fixes a bug, when click on span, focus on the input
function inputFocus(x){
    x.previousElementSibling.focus();
}

//Check if the input is filled, then fix the span
function checkInput(x){
    if(x.value != ""){
        x.nextElementSibling.style.bottom = "95%";
        if(document.getElementById('sl__warning'))
            document.getElementById('sl__warning').style.display = "none";
    } else {
        x.nextElementSibling.style.bottom = "";
    }
}

//check if there's some item filled
function checkFilled(){
    let input_item = document.getElementsByClassName('input-item');
    var count = 0;
    for(var i = 0; i < input_item.length; i++){
        if(input_item[i].value != "")
            count++;
    }
    if(count > 0){
        document.getElementById('submit__button').click();
    } else {
        triggerWarning();
        triggerModal('anything');
    }
}

//warning to require at least one input to be filled
function triggerWarning(){
    let warning = document.getElementById('sl__warning');

    warning.style.display = "block";
    warning.innerHTML = "Por favor, insira pelo menos <strong>1</strong> item";
}

//trigger blur to elements
function triggerBlurEffect(x){
    var nvb = document.getElementById('app-navbar');
    var list = document.getElementById('app-list');

    if(x == 1){
        nvb.style.filter = "blur(3px)";
        list.style.filter = "blur(3px)";
    } else {
        nvb.style.filter = "";
        list.style.filter = "";
    }
    
}

//set the position of app-footer
function adjustPosition(){
    let app_footer = document.getElementById('app-footer');
    let appf_header = document.getElementsByClassName('dl-header')[0];

    app_footer.style.top = window.innerHeight - appf_header.offsetHeight;
}

//Show the details of the shopping
function showDetails(x){
    // alert('scrolled');
    var apf = document.getElementById('app-footer');
    var bkgd = document.getElementById('app-background');

    apf.style.top = "10%";
    bkgd.style.display = "block";
    x.style.transform = "rotate(0)";
    triggerBlurEffect(1);

    x.setAttribute('onclick', 'hideDetails(this)');
}

//Hide the details
function hideDetails(x){
    var apf = document.getElementById('app-footer');
    var bkgd = document.getElementById('app-background');

    adjustPosition();
    bkgd.style.display = "none";
    x.style.transform = "rotate(180deg)";

    triggerBlurEffect(2);

    x.setAttribute('onclick', 'showDetails(this)');
}

// console.log('kk');
//Insert a new product field
var i = 3; //number of inputs -> starts at 3
function newProductField(){
    // console.log('Inside newProductField');
    i++;
    var divInputField = document.createElement('div');
    var inputItem = document.createElement('input');
    var spanText = document.createElement('span');

    divInputField.setAttribute('class', 'sl-input-field');
    divInputField.setAttribute('id', 'box-item-'+i);

    inputItem.setAttribute('type', 'text');
    inputItem.setAttribute('onkeyup', 'checkInput(this)');
    inputItem.setAttribute('name', i);
    inputItem.setAttribute('id', 'input-item-'+i);
    inputItem.setAttribute('class', 'input-item');

    spanText.setAttribute('class', 'placeholder-text');
    spanText.setAttribute('onclick', 'inputFocus(this)');
    spanText.innerHTML = "Add some item...";

    divInputField.appendChild(inputItem);
    divInputField.appendChild(spanText);

    document.getElementsByClassName('sl-body')[0].appendChild(divInputField);

}

// function test(){
//     console.log('fuck');
// }

function triggerModal(x){
    // var closeBtn = document.getElementById('close-modal');
    // var closeX = document.getElementById('close');
    var modal = document.getElementById('modal');

    if(x.id == "go-shopping"){
        modal.style.display = "block";
        triggerBlurEffect(1);
    } else {
        modal.style.display = "none";
        triggerBlurEffect(2);
    }
}

//set the currency input
function currencyChecker(x){
    let form_input = document.getElementById('sl__value');

    //removes the comma and the dot
    var newX = x.value.replace(',','');
    newX = newX.replace('.', '');

    //split the entire number
    var s = newX.split('');

    //add the comma at the last third position
    if(s.length >= 3){
        var c = newX.slice(0, s.length-2) + "." + newX.slice(s.length-2);
        // console.log("insert comma: "+c);
        x.value = c;
    }

    if(form_input)
        form_input.value = c;

    return c;

    //add the dot at the second position
    // if(s.length >= 6){
    //     var d = c.slice(0, s.length-5) + "." + c.slice(s.length-5);
    //     console.log('insert dot: '+d);
    //     x.value = d;
    // }
}

var price = 0;
var balanceField = document.getElementById('balance');
if(balanceField)
var initBalance = parseFloat(balanceField.textContent);
var valueField = document.getElementsByClassName('price-input');
var quantFieldD = document.getElementsByClassName('quant-input');
var hidden_balance = document.getElementById('hidden__balance');
hidden_balance.value = initBalance;
var hidden_finalp = document.getElementById('hidden__final-price');

//sum the total value
function countValue(x){
    //set quantity on desc list | call this function only if the input is type="number"
    if(x.type == "number"){
        setQuantity(x);
    } else {
        //set price on desc list
        setPrice(x);
        //forces another setup on currency
        currencyChecker(x);
    }
    
    //set balance field to init value every time the function is called
    balanceField.textContent = initBalance;

    var priceField = document.getElementById('money');
    var quantField = x.previousElementSibling;
    var finalPrice;
    var balance;
    var sum = 0;

    price = parseFloat(x.value);
    quant = parseInt(quantField.value);
    balance = parseFloat(balanceField.textContent);

    for(var i = 0; i < valueField.length; i++){
        if(valueField[i].value != "" && quantFieldD[i].value != ""){
            sum += parseFloat(valueField[i].value) * parseFloat(quantFieldD[i].value);
        }
    }
    
    finalPrice = balance - sum;
    balanceField.textContent = finalPrice.toFixed(2);
    priceField.textContent = sum.toFixed(2);
    hidden_finalp.value = sum.toFixed(2);

    if(finalPrice < 0){
        let balance_span = document.getElementById('dl__balance');
        balance_span.classList.add('overbalance');
    } else {
        let balance_span = document.getElementById('dl__balance');
        balance_span.classList.remove('overbalance');
    }

    // console.log(sum);

    // console.log(x.value);
}

//set price on desc-list
function setPrice(x){
    let product_price = currencyChecker(x);
    let new_id = x.id.replace('input-item-', 'product-price-');

    document.getElementById(new_id).textContent = product_price;
}

//set quantity of product on desc list
function setQuantity(x){
    let new_id = x.id.replace('quant-item-', 'product-quant-');

    document.getElementById(new_id).textContent = x.value;
}

//show/hide add item modal
function toggleAddItemModal(x){
    let modal = document.getElementById('modal__add-item');
    let bg = document.getElementById('app-background');
    let app = document.getElementsByClassName('app')[0];

    if(x){
        app.style.filter = "blur(3px)";
        modal.style.display = "block";
        bg.style.display = "block";
    } else {
        app.style.filter = "";
        modal.style.display = "none";
        bg.style.display = "none";
    }   
}

//adds a new extra item
function addItem(){
    let container = document.getElementById('sl__body');
    let container2 = document.getElementById('extra__list');
    let count = container.childElementCount + 1;
    let item_name = document.getElementById('input_add-item');
    document.getElementById('--extra__list').style.display = "block";

    //create element on list
    let box = document.createElement('div');
    box.setAttribute('class', 'sl-input-field');
    box.setAttribute('id', 'box-item-'+count);

    let box_span = document.createElement('span');
    box_span.setAttribute('class', 'product-name');
    box_span.textContent = item_name.value;

    let hidden_inp_name = document.createElement('input');
    hidden_inp_name.setAttribute('type', 'hidden');
    hidden_inp_name.setAttribute('style', 'display: none');
    hidden_inp_name.setAttribute('name', 'product-name-'+count);
    hidden_inp_name.setAttribute('value', item_name.value);

    let hidden_inp_extra = document.createElement('input');
    hidden_inp_extra.setAttribute('type', 'hidden');
    hidden_inp_extra.setAttribute('style', 'display: none');
    hidden_inp_extra.setAttribute('name', 'is-extra-'+count);
    hidden_inp_extra.setAttribute('value', 1);

    let box_inp_nb = document.createElement('input');
    box_inp_nb.setAttribute('type', 'number');
    box_inp_nb.setAttribute('onchange', 'countValue(this)');
    box_inp_nb.setAttribute('id', 'quant-item-'+count);
    box_inp_nb.setAttribute('class', 'input-item quant-input');
    box_inp_nb.setAttribute('name', 'product-quant-'+count);
    box_inp_nb.setAttribute('value', 1);

    let box_inp_tx = document.createElement('input');
    box_inp_tx.setAttribute('type', 'text');
    box_inp_tx.setAttribute('onchange', 'countValue(this)');
    box_inp_tx.setAttribute('onkeyup', 'checkInput(this);currencyChecker(this)');
    box_inp_tx.setAttribute('id', 'input-item-'+count);
    box_inp_tx.setAttribute('name', 'product-price-'+count);
    box_inp_tx.setAttribute('class', 'input-item price-input');

    let box_sec_span = document.createElement('span');
    box_sec_span.setAttribute('class', 'placeholder-text');
    box_sec_span.setAttribute('onclick', 'inputFocus(this)');
    box_sec_span.textContent = "valor";

    box.appendChild(box_span);
    box.appendChild(hidden_inp_name);
    box.appendChild(hidden_inp_extra);
    box.appendChild(box_inp_nb);
    box.appendChild(box_inp_tx);
    box.appendChild(box_sec_span);
    
    //create element on desc list

    let abox = document.createElement('div');
    abox.setAttribute('class', 'product extra');

    let box2 = document.createElement('div');
    box2.setAttribute('class', 'left');

    let abox_span = document.createElement('span');
    abox_span.setAttribute('class', 'product-name');
    abox_span.setAttribute('id', 'product-name-'+count);
    abox_span.textContent = item_name.value;

    let box3 = document.createElement('div');
    box3.setAttribute('class', 'right');

    let box_span2 = document.createElement('span');
    box_span2.setAttribute('id', 'product-quant-'+count);
    box_span2.textContent = 1;

    let box_span3 = document.createElement('span');
    box_span3.setAttribute('class', 'pr-subtitle');
    box_span3.textContent = "R$ ";

    let box_span4 = document.createElement('span');
    box_span4.setAttribute('class', 'product-price');
    box_span4.setAttribute('id', 'product-price-'+count);
    box_span4.textContent = "---";

    abox.appendChild(box2);
    box2.appendChild(abox_span);
    abox.appendChild(box3);
    box3.appendChild(box_span2);
    box3.innerHTML += " x ";
    box3.appendChild(box_span3);
    box_span3.appendChild(box_span4);

    container2.appendChild(abox);
    container.appendChild(box);

    toggleAddItemModal(false);
}