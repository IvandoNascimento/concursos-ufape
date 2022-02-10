@extends('templates.template-principal')
@section('content')
<div class="container" style="margin-top: 5rem; margin-bottom: 8rem;">
    <div class="form-row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow bg-white style_card_container">
                <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                    <h6 class="style_card_container_header_titulo">Cadastre-se</h6>
                    <h6 class="style_card_container_header_campo_obrigatorio"><span style="color: red; font-weight: bold;">*</span> Campo obrigatório</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <h6 class="style_card_container_header_subtitulo">Acesso ao sistema</h6>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="email" class="style_campo_titulo">E-mail <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="email" class="form-control style_campo @error('email') is-invalid @enderror" id="email" name="email"
                                    placeholder="Digite seu e-mail" value="{{ old('email') }}" required autofocus/>
                                @error('email')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="password" class="style_campo_titulo">Senha <span style="color: red; font-weight: bold;">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control style_campo @error('password') is-invalid @enderror" id="password" name="password"
                                        placeholder="Digite sua senha" required autocomplete="new-password" aria-label="Recipient's username" aria-describedby="button-addon2"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" style="padding: 0px; padding-left: 10px; padding-right: 10px;"
                                                onmouseover="alterarImagem(this)" onmouseout="alterarImagem(this)"
                                                onclick="visualizarSenha(this)">
                                            <img src="{{asset('img/icon_visualizar_cinza.svg')}}" alt="" style="width: 20px;">
                                        </button>
                                    </div>
                                </div>
                                
                                @error('password')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small>A senha deve ter no mínimo 8 caracteres e pode ser composta de letras e números.</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="password_confirmation" class="style_campo_titulo">Confirmar senha <span style="color: red; font-weight: bold;">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control style_campo" id="password_confirmation" name="password_confirmation"
                                        placeholder="Confirme sua senha" required autocomplete="new-password" />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon1" style="padding: 0px; padding-left: 10px; padding-right: 10px;"
                                                onmouseover="alterarImagem(this)" onmouseout="alterarImagem(this)"
                                                onclick="visualizarSenha(this)">
                                            <img src="{{asset('img/icon_visualizar_cinza.svg')}}" alt="" style="width: 20px;">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <h6 class="style_card_container_header_subtitulo">Informações pessoais</h6>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="nome" class="style_campo_titulo">Nome <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('nome') is-invalid @enderror" id="nome" name="nome"
                                    placeholder="Digite seu nome" value="{{ old('nome') }}" minlength="5" maxlength="200" required autocomplete="nome"/>
                                @error('nome')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="sobrenome" class="style_campo_titulo">Sobrenome <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('sobrenome') is-invalid @enderror" id="sobrenome" name="sobrenome"
                                    value="{{ old('sobrenome') }}" placeholder="Digite seu sobrenome" minlength="5" maxlength="200" required />
                                @error('sobrenome')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="nome_do_pai" class="style_campo_titulo">Nome do pai</label>
                                <input type="text" class="form-control style_campo @error('nome_do_pai') is-invalid @enderror" id="nome_do_pai" name="nome_do_pai"
                                    placeholder="Digite o nome de seu pai" value="{{ old('nome_do_pai') }}" minlength="10" maxlength="200" />
                                @error('nome_do_pai')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nome_da_mãe" class="style_campo_titulo">Nome da mãe <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('nome_da_mãe') is-invalid @enderror" id="nome_da_mãe" name="nome_da_mãe"
                                    placeholder="Digite o nome da sua mãe" value="{{ old('nome_da_mãe') }}" minlength="10" maxlength="200" required />
                                @error('nome_da_mãe')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="data_de_nascimento" class="style_campo_titulo">Data de nascimento <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="date" class="form-control style_campo @error('data_de_nascimento') is-invalid @enderror" id="data_de_nascimento" name="data_de_nascimento"
                                    placeholder="Digite seu CPF" value="{{ old('data_de_nascimento') }}" required/>
                                @error('data_de_nascimento')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <p for="estrangeiro" class="style_campo_titulo">Estrangeiro <span style="color: red; font-weight: bold;">*</span></p>
                                <input type="radio" class="style_campo" id="sim" name="estrangeiro" placeholder="Digite o seu número" value="sim" required onclick="exibirMsg(this)" @if(old('estrangeiro') == "sim") checked @endif/>
                                <label for="sim">Sim</label>
                                <input type="radio" class="style_campo" id="nao" name="estrangeiro" placeholder="Digite o seu número" value="não" required onclick="exibirMsg(this)" @if(old('estrangeiro') == "não") checked @endif/>
                                <label for="nao">Não</label>

                                @error('estrangeiro')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="documento_de_identificação" class="style_campo_titulo">Documento de identificação <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('documento_de_identificação') is-invalid @enderror" id="documento_de_identificação" name="documento_de_identificação"
                                    placeholder="Digite o número do documento de identificação" value="{{ old('documento_de_identificação') }}" required />
                                <small id="msg-estrangeiro-pasaporte" style="@if(old('documento_de_identificação') != null) display: inline; @else display: none; @endif">Caso candidato estrangeiro informar número de passaporte com letras e números.</small>
                                @error('documento_de_identificação')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div id="div-orgao-emissor" class="col-md-6 form-group" style="@if(old('estrangeiro') == "sim") display: none; @else display: block; @endif">
                                <label for="órgao_emissor" class="style_campo_titulo">Órgão emissor <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('órgao_emissor') is-invalid @enderror" id="órgao_emissor" name="órgao_emissor"
                                    placeholder="Digite o órgão emissor do documento" value="{{ old('órgao_emissor') }}"/>
                                @error('órgao_emissor')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input id="país_de_origem_input_hidden" type="hidden" value="{{old('país_de_origem')}}" name="país_de_origem">
                                <label for="país_de_origem" class="style_campo_titulo">País de origem <span style="color: red; font-weight: bold;">*</span></label>
                                <select id="país_de_origem" class="form-control style_campo @error('país_de_origem') is-invalid @enderror" required onchange="setarInputPais(this)">
                                    <option value="" disabled selected >-- Selecione seu país de origem --</option>
                                    <option @if(old('país_de_origem') == "Brasil") selected @endif value="Brasil">Brasil</option>
                                    <option @if(old('país_de_origem') == "Afeganistão") selected @endif value="Afeganistão">Afeganistão</option>
                                    <option @if(old('país_de_origem') == "África do Sul") selected @endif value="África do Sul">África do Sul</option>
                                    <option @if(old('país_de_origem') == "Albânia") selected @endif value="Albânia">Albânia</option>
                                    <option @if(old('país_de_origem') == "Alemanha") selected @endif value="Alemanha">Alemanha</option>
                                    <option @if(old('país_de_origem') == "Andorra") selected @endif value="Andorra">Andorra</option>
                                    <option @if(old('país_de_origem') == "Angola") selected @endif value="Angola">Angola</option>
                                    <option @if(old('país_de_origem') == "Anguilla") selected @endif value="Anguilla">Anguilla</option>
                                    <option @if(old('país_de_origem') == "Antilhas Holandesas") selected @endif value="Antilhas Holandesas">Antilhas Holandesas</option>
                                    <option @if(old('país_de_origem') == "Antárctida") selected @endif value="Antárctida">Antárctida</option>
                                    <option @if(old('país_de_origem') == "Antígua e Barbuda") selected @endif value="Antígua e Barbuda">Antígua e Barbuda</option>
                                    <option @if(old('país_de_origem') == "Argentina") selected @endif value="Argentina">Argentina</option>
                                    <option @if(old('país_de_origem') == "Argélia") selected @endif value="Argélia">Argélia</option>
                                    <option @if(old('país_de_origem') == "Armênia") selected @endif value="Armênia">Armênia</option>
                                    <option @if(old('país_de_origem') == "Aruba") selected @endif value="Aruba">Aruba</option>
                                    <option @if(old('país_de_origem') == "Arábia Saudita") selected @endif value="Arábia Saudita">Arábia Saudita</option>
                                    <option @if(old('país_de_origem') == "Austrália") selected @endif value="Austrália">Austrália</option>
                                    <option @if(old('país_de_origem') == "Áustria") selected @endif value="Áustria">Áustria</option>
                                    <option @if(old('país_de_origem') == "Azerbaijão") selected @endif value="Azerbaijão">Azerbaijão</option>
                                    <option @if(old('país_de_origem') == "Bahamas") selected @endif value="Bahamas">Bahamas</option>
                                    <option @if(old('país_de_origem') == "Bahrein") selected @endif value="Bahrein">Bahrein</option>
                                    <option @if(old('país_de_origem') == "Bangladesh") selected @endif value="Bangladesh">Bangladesh</option>
                                    <option @if(old('país_de_origem') == "Barbados") selected @endif value="Barbados">Barbados</option>
                                    <option @if(old('país_de_origem') == "Belize") selected @endif value="Belize">Belize</option>
                                    <option @if(old('país_de_origem') == "Benim") selected @endif value="Benim">Benim</option>
                                    <option @if(old('país_de_origem') == "Bermudas") selected @endif value="Bermudas">Bermudas</option>
                                    <option @if(old('país_de_origem') == "Bielorrússia") selected @endif value="Bielorrússia">Bielorrússia</option>
                                    <option @if(old('país_de_origem') == "Bolívia") selected @endif value="Bolívia">Bolívia</option>
                                    <option @if(old('país_de_origem') == "Botswana") selected @endif value="Botswana">Botswana</option>
                                    <option @if(old('país_de_origem') == "Brunei") selected @endif value="Brunei">Brunei</option>
                                    <option @if(old('país_de_origem') == "Bulgária") selected @endif value="Bulgária">Bulgária</option>
                                    <option @if(old('país_de_origem') == "Burkina Faso") selected @endif value="Burkina Faso">Burkina Faso</option>
                                    <option @if(old('país_de_origem') == "Burundi") selected @endif value="Burundi">Burundi</option>
                                    <option @if(old('país_de_origem') == "Butão") selected @endif value="Butão">Butão</option>
                                    <option @if(old('país_de_origem') == "Bélgica") selected @endif value="Bélgica">Bélgica</option>
                                    <option @if(old('país_de_origem') == "Bósnia e Herzegovina") selected @endif value="Bósnia e Herzegovina">Bósnia e Herzegovina</option>
                                    <option @if(old('país_de_origem') == "Cabo Verde") selected @endif value="Cabo Verde">Cabo Verde</option>
                                    <option @if(old('país_de_origem') == "Camarões") selected @endif value="Camarões">Camarões</option>
                                    <option @if(old('país_de_origem') == "Camboja") selected @endif value="Camboja">Camboja</option>
                                    <option @if(old('país_de_origem') == "Canadá") selected @endif value="Canadá">Canadá</option>
                                    <option @if(old('país_de_origem') == "Catar") selected @endif value="Catar">Catar</option>
                                    <option @if(old('país_de_origem') == "Cazaquistão") selected @endif value="Cazaquistão">Cazaquistão</option>
                                    <option @if(old('país_de_origem') == "Chade") selected @endif value="Chade">Chade</option>
                                    <option @if(old('país_de_origem') == "Chile") selected @endif value="Chile">Chile</option>
                                    <option @if(old('país_de_origem') == "China") selected @endif value="China">China</option>
                                    <option @if(old('país_de_origem') == "Chipre") selected @endif value="Chipre">Chipre</option>
                                    <option @if(old('país_de_origem') == "Colômbia") selected @endif value="Colômbia">Colômbia</option>
                                    <option @if(old('país_de_origem') == "Comores") selected @endif value="Comores">Comores</option>
                                    <option @if(old('país_de_origem') == "Coreia do Norte") selected @endif value="Coreia do Norte">Coreia do Norte</option>
                                    <option @if(old('país_de_origem') == "Coreia do Sul") selected @endif value="Coreia do Sul">Coreia do Sul</option>
                                    <option @if(old('país_de_origem') == "Costa do Marfim") selected @endif value="Costa do Marfim">Costa do Marfim</option>
                                    <option @if(old('país_de_origem') == "Costa Rica") selected @endif value="Costa Rica">Costa Rica</option>
                                    <option @if(old('país_de_origem') == "Croácia") selected @endif value="Croácia">Croácia</option>
                                    <option @if(old('país_de_origem') == "Cuba") selected @endif value="Cuba">Cuba</option>
                                    <option @if(old('país_de_origem') == "Dinamarca") selected @endif value="Dinamarca">Dinamarca</option>
                                    <option @if(old('país_de_origem') == "Djibouti") selected @endif value="Djibouti">Djibouti</option>
                                    <option @if(old('país_de_origem') == "Dominica") selected @endif value="Dominica">Dominica</option>
                                    <option @if(old('país_de_origem') == "Egito") selected @endif value="Egito">Egito</option>
                                    <option @if(old('país_de_origem') == "El Salvador") selected @endif value="El Salvador">El Salvador</option>
                                    <option @if(old('país_de_origem') == "Emirados Árabes Unidos") selected @endif value="Emirados Árabes Unidos">Emirados Árabes Unidos</option>
                                    <option @if(old('país_de_origem') == "Equador") selected @endif value="Equador">Equador</option>
                                    <option @if(old('país_de_origem') == "Eritreia") selected @endif value="Eritreia">Eritreia</option>
                                    <option @if(old('país_de_origem') == "Escócia") selected @endif value="Escócia">Escócia</option>
                                    <option @if(old('país_de_origem') == "Eslováquia") selected @endif value="Eslováquia">Eslováquia</option>
                                    <option @if(old('país_de_origem') == "Eslovênia") selected @endif value="Eslovênia">Eslovênia</option>
                                    <option @if(old('país_de_origem') == "Espanha") selected @endif value="Espanha">Espanha</option>
                                    <option @if(old('país_de_origem') == "Estados Federados da Micronésia") selected @endif value="Estados Federados da Micronésia">Estados Federados da Micronésia</option>
                                    <option @if(old('país_de_origem') == "Estados Unidos") selected @endif value="Estados Unidos">Estados Unidos</option>
                                    <option @if(old('país_de_origem') == "Estônia") selected @endif value="Estônia">Estônia</option>
                                    <option @if(old('país_de_origem') == "Etiópia") selected @endif value="Etiópia">Etiópia</option>
                                    <option @if(old('país_de_origem') == "Fiji") selected @endif value="Fiji">Fiji</option>
                                    <option @if(old('país_de_origem') == "Filipinas") selected @endif value="Filipinas">Filipinas</option>
                                    <option @if(old('país_de_origem') == "Finlândia") selected @endif value="Finlândia">Finlândia</option>
                                    <option @if(old('país_de_origem') == "França") selected @endif value="França">França</option>
                                    <option @if(old('país_de_origem') == "Gabão") selected @endif value="Gabão">Gabão</option>
                                    <option @if(old('país_de_origem') == "Gana") selected @endif value="Gana">Gana</option>
                                    <option @if(old('país_de_origem') == "Geórgia") selected @endif value="Geórgia">Geórgia</option>
                                    <option @if(old('país_de_origem') == "Gibraltar") selected @endif value="Gibraltar">Gibraltar</option>
                                    <option @if(old('país_de_origem') == "Granada") selected @endif value="Granada">Granada</option>
                                    <option @if(old('país_de_origem') == "Gronelândia") selected @endif value="Gronelândia">Gronelândia</option>
                                    <option @if(old('país_de_origem') == "Grécia") selected @endif value="Grécia">Grécia</option>
                                    <option @if(old('país_de_origem') == "Guadalupe") selected @endif value="Guadalupe">Guadalupe</option>
                                    <option @if(old('país_de_origem') == "Guam") selected @endif value="Guam">Guam</option>
                                    <option @if(old('país_de_origem') == "Guatemala") selected @endif value="Guatemala">Guatemala</option>
                                    <option @if(old('país_de_origem') == "Guernesei") selected @endif value="Guernesei">Guernesei</option>
                                    <option @if(old('país_de_origem') == "Guiana") selected @endif value="Guiana">Guiana</option>
                                    <option @if(old('país_de_origem') == "Guiana Francesa") selected @endif value="Guiana Francesa">Guiana Francesa</option>
                                    <option @if(old('país_de_origem') == "Guiné") selected @endif value="Guiné">Guiné</option>
                                    <option @if(old('país_de_origem') == "Guiné Equatorial") selected @endif value="Guiné Equatorial">Guiné Equatorial</option>
                                    <option @if(old('país_de_origem') == "Guiné-Bissau") selected @endif value="Guiné-Bissau">Guiné-Bissau</option>
                                    <option @if(old('país_de_origem') == "Gâmbia") selected @endif value="Gâmbia">Gâmbia</option>
                                    <option @if(old('país_de_origem') == "Haiti") selected @endif value="Haiti">Haiti</option>
                                    <option @if(old('país_de_origem') == "Honduras") selected @endif value="Honduras">Honduras</option>
                                    <option @if(old('país_de_origem') == "Hong Kong") selected @endif value="Hong Kong">Hong Kong</option>
                                    <option @if(old('país_de_origem') == "Hungria") selected @endif value="Hungria">Hungria</option>
                                    <option @if(old('país_de_origem') == "Ilha Bouvet") selected @endif value="Ilha Bouvet">Ilha Bouvet</option>
                                    <option @if(old('país_de_origem') == "Ilha de Man") selected @endif value="Ilha de Man">Ilha de Man</option>
                                    <option @if(old('país_de_origem') == "Ilha do Natal") selected @endif value="Ilha do Natal">Ilha do Natal</option>
                                    <option @if(old('país_de_origem') == "Ilha Heard e Ilhas McDonald") selected @endif value="Ilha Heard e Ilhas McDonald">Ilha Heard e Ilhas McDonald</option>
                                    <option @if(old('país_de_origem') == "Ilha Norfolk") selected @endif value="Ilha Norfolk">Ilha Norfolk</option>
                                    <option @if(old('país_de_origem') == "Ilhas Cayman") selected @endif value="Ilhas Cayman">Ilhas Cayman</option>
                                    <option @if(old('país_de_origem') == "Ilhas Cocos (Keeling)") selected @endif value="Ilhas Cocos (Keeling)">Ilhas Cocos (Keeling)</option>
                                    <option @if(old('país_de_origem') == "Ilhas Cook") selected @endif value="Ilhas Cook">Ilhas Cook</option>
                                    <option @if(old('país_de_origem') == "Ilhas Feroé") selected @endif value="Ilhas Feroé">Ilhas Feroé</option>
                                    <option @if(old('país_de_origem') == "Ilhas Geórgia do Sul e Sandwich do Sul") selected @endif value="Ilhas Geórgia do Sul e Sandwich do Sul">Ilhas Geórgia do Sul e Sandwich do Sul</option>
                                    <option @if(old('país_de_origem') == "Ilhas Malvinas") selected @endif value="Ilhas Malvinas">Ilhas Malvinas</option>
                                    <option @if(old('país_de_origem') == "Ilhas Marshall") selected @endif value="Ilhas Marshall">Ilhas Marshall</option>
                                    <option @if(old('país_de_origem') == "Ilhas Menores Distantes dos Estados Unidos") selected @endif value="Ilhas Menores Distantes dos Estados Unidos">Ilhas Menores Distantes dos Estados Unidos</option>
                                    <option @if(old('país_de_origem') == "Ilhas Salomão") selected @endif value="Ilhas Salomão">Ilhas Salomão</option>
                                    <option @if(old('país_de_origem') == "Ilhas Virgens Americanas") selected @endif value="Ilhas Virgens Americanas">Ilhas Virgens Americanas</option>
                                    <option @if(old('país_de_origem') == "Ilhas Virgens Britânicas") selected @endif value="Ilhas Virgens Britânicas">Ilhas Virgens Britânicas</option>
                                    <option @if(old('país_de_origem') == "Ilhas Åland") selected @endif value="Ilhas Åland">Ilhas Åland</option>
                                    <option @if(old('país_de_origem') == "Indonésia") selected @endif value="Indonésia">Indonésia</option>
                                    <option @if(old('país_de_origem') == "Inglaterra") selected @endif value="Inglaterra">Inglaterra</option>
                                    <option @if(old('país_de_origem') == "Índia") selected @endif value="Índia">Índia</option>
                                    <option @if(old('país_de_origem') == "Iraque") selected @endif value="Iraque">Iraque</option>
                                    <option @if(old('país_de_origem') == "Irlanda do Norte") selected @endif value="Irlanda do Norte">Irlanda do Norte</option>
                                    <option @if(old('país_de_origem') == "Irlanda") selected @endif value="Irlanda">Irlanda</option>
                                    <option @if(old('país_de_origem') == "Irã") selected @endif value="Irã">Irã</option>
                                    <option @if(old('país_de_origem') == "Islândia") selected @endif value="Islândia">Islândia</option>
                                    <option @if(old('país_de_origem') == "Israel") selected @endif value="Israel">Israel</option>
                                    <option @if(old('país_de_origem') == "Itália") selected @endif value="Itália">Itália</option>
                                    <option @if(old('país_de_origem') == "Iêmen") selected @endif value="Iêmen">Iêmen</option>
                                    <option @if(old('país_de_origem') == "Jamaica") selected @endif value="Jamaica">Jamaica</option>
                                    <option @if(old('país_de_origem') == "Japão") selected @endif value="Japão">Japão</option>
                                    <option @if(old('país_de_origem') == "Jersey") selected @endif value="Jersey">Jersey</option>
                                    <option @if(old('país_de_origem') == "Jordânia") selected @endif value="Jordânia">Jordânia</option>
                                    <option @if(old('país_de_origem') == "Kiribati") selected @endif value="Kiribati">Kiribati</option>
                                    <option @if(old('país_de_origem') == "Kuwait") selected @endif value="Kuwait">Kuwait</option>
                                    <option @if(old('país_de_origem') == "Laos") selected @endif value="Laos">Laos</option>
                                    <option @if(old('país_de_origem') == "Lesoto") selected @endif value="Lesoto">Lesoto</option>
                                    <option @if(old('país_de_origem') == "Letônia") selected @endif value="Letônia">Letônia</option>
                                    <option @if(old('país_de_origem') == "Libéria") selected @endif value="Libéria">Libéria</option>
                                    <option @if(old('país_de_origem') == "Liechtenstein") selected @endif value="Liechtenstein">Liechtenstein</option>
                                    <option @if(old('país_de_origem') == "Lituânia") selected @endif value="Lituânia">Lituânia</option>
                                    <option @if(old('país_de_origem') == "Luxemburgo") selected @endif value="Luxemburgo">Luxemburgo</option>
                                    <option @if(old('país_de_origem') == "Líbano") selected @endif value="Líbano">Líbano</option>
                                    <option @if(old('país_de_origem') == "Líbia") selected @endif value="Líbia">Líbia</option>
                                    <option @if(old('país_de_origem') == "Macau") selected @endif value="Macau">Macau</option>
                                    <option @if(old('país_de_origem') == "Macedônia") selected @endif value="Macedônia">Macedônia</option>
                                    <option @if(old('país_de_origem') == "Madagáscar") selected @endif value="Madagáscar">Madagáscar</option>
                                    <option @if(old('país_de_origem') == "Malawi") selected @endif value="Malawi">Malawi</option>
                                    <option @if(old('país_de_origem') == "Maldivas") selected @endif value="Maldivas">Maldivas</option>
                                    <option @if(old('país_de_origem') == "Mali") selected @endif value="Mali">Mali</option>
                                    <option @if(old('país_de_origem') == "Malta") selected @endif value="Malta">Malta</option>
                                    <option @if(old('país_de_origem') == "Malásia") selected @endif value="Malásia">Malásia</option>
                                    <option @if(old('país_de_origem') == "Marianas Setentrionais") selected @endif value="Marianas Setentrionais">Marianas Setentrionais</option>
                                    <option @if(old('país_de_origem') == "Marrocos") selected @endif value="Marrocos">Marrocos</option>
                                    <option @if(old('país_de_origem') == "Martinica") selected @endif value="Martinica">Martinica</option>
                                    <option @if(old('país_de_origem') == "Mauritânia") selected @endif value="Mauritânia">Mauritânia</option>
                                    <option @if(old('país_de_origem') == "Maurícia") selected @endif value="Maurícia">Maurícia</option>
                                    <option @if(old('país_de_origem') == "Mayotte") selected @endif value="Mayotte">Mayotte</option>
                                    <option @if(old('país_de_origem') == "Moldávia") selected @endif value="Moldávia">Moldávia</option>
                                    <option @if(old('país_de_origem') == "Mongólia") selected @endif value="Mongólia">Mongólia</option>
                                    <option @if(old('país_de_origem') == "Montenegro") selected @endif value="Montenegro">Montenegro</option>
                                    <option @if(old('país_de_origem') == "Montserrat") selected @endif value="Montserrat">Montserrat</option>
                                    <option @if(old('país_de_origem') == "Moçambique") selected @endif value="Moçambique">Moçambique</option>
                                    <option @if(old('país_de_origem') == "Myanmar") selected @endif value="Myanmar">Myanmar</option>
                                    <option @if(old('país_de_origem') == "México") selected @endif value="México">México</option>
                                    <option @if(old('país_de_origem') == "Mônaco") selected @endif value="Mônaco">Mônaco</option>
                                    <option @if(old('país_de_origem') == "Namíbia") selected @endif value="Namíbia">Namíbia</option>
                                    <option @if(old('país_de_origem') == "Nauru") selected @endif value="Nauru">Nauru</option>
                                    <option @if(old('país_de_origem') == "Nepal") selected @endif value="Nepal">Nepal</option>
                                    <option @if(old('país_de_origem') == "Nicarágua") selected @endif value="Nicarágua">Nicarágua</option>
                                    <option @if(old('país_de_origem') == "Nigéria") selected @endif value="Nigéria">Nigéria</option>
                                    <option @if(old('país_de_origem') == "Niue") selected @endif value="Niue">Niue</option>
                                    <option @if(old('país_de_origem') == "Noruega") selected @endif value="Noruega">Noruega</option>
                                    <option @if(old('país_de_origem') == "Nova Caledônia") selected @endif value="Nova Caledônia">Nova Caledônia</option>
                                    <option @if(old('país_de_origem') == "Nova Zelândia") selected @endif value="Nova Zelândia">Nova Zelândia</option>
                                    <option @if(old('país_de_origem') == "Níger") selected @endif value="Níger">Níger</option>
                                    <option @if(old('país_de_origem') == "Omã") selected @endif value="Omã">Omã</option>
                                    <option @if(old('país_de_origem') == "Palau") selected @endif value="Palau">Palau</option>
                                    <option @if(old('país_de_origem') == "Palestina") selected @endif value="Palestina">Palestina</option>
                                    <option @if(old('país_de_origem') == "Panamá") selected @endif value="Panamá">Panamá</option>
                                    <option @if(old('país_de_origem') == "Papua-Nova Guiné") selected @endif value="Papua-Nova Guiné">Papua-Nova Guiné</option>
                                    <option @if(old('país_de_origem') == "Paquistão") selected @endif value="Paquistão">Paquistão</option>
                                    <option @if(old('país_de_origem') == "Paraguai") selected @endif value="Paraguai">Paraguai</option>
                                    <option @if(old('país_de_origem') == "País de Gales") selected @endif value="País de Gales">País de Gales</option>
                                    <option @if(old('país_de_origem') == "Países Baixos") selected @endif value="Países Baixos">Países Baixos</option>
                                    <option @if(old('país_de_origem') == "Peru") selected @endif value="Peru">Peru</option>
                                    <option @if(old('país_de_origem') == "Pitcairn") selected @endif value="Pitcairn">Pitcairn</option>
                                    <option @if(old('país_de_origem') == "Polinésia Francesa") selected @endif value="Polinésia Francesa">Polinésia Francesa</option>
                                    <option @if(old('país_de_origem') == "Polônia") selected @endif value="Polônia">Polônia</option>
                                    <option @if(old('país_de_origem') == "Porto Rico") selected @endif value="Porto Rico">Porto Rico</option>
                                    <option @if(old('país_de_origem') == "Portugal") selected @endif value="Portugal">Portugal</option>
                                    <option @if(old('país_de_origem') == "Quirguistão") selected @endif value="Quirguistão">Quirguistão</option>
                                    <option @if(old('país_de_origem') == "Quênia") selected @endif value="Quênia">Quênia</option>
                                    <option @if(old('país_de_origem') == "Reino Unido") selected @endif value="Reino Unido">Reino Unido</option>
                                    <option @if(old('país_de_origem') == "República Centro-Africana") selected @endif value="República Centro-Africana">República Centro-Africana</option>
                                    <option @if(old('país_de_origem') == "República Checa") selected @endif value="República Checa">República Checa</option>
                                    <option @if(old('país_de_origem') == "República Democrática do Congo") selected @endif value="República Democrática do Congo">República Democrática do Congo</option>
                                    <option @if(old('país_de_origem') == "República do Congo") selected @endif value="República do Congo">República do Congo</option>
                                    <option @if(old('país_de_origem') == "República Dominicana") selected @endif value="República Dominicana">República Dominicana</option>
                                    <option @if(old('país_de_origem') == "Reunião") selected @endif value="Reunião">Reunião</option>
                                    <option @if(old('país_de_origem') == "Romênia") selected @endif value="Romênia">Romênia</option>
                                    <option @if(old('país_de_origem') == "Ruanda") selected @endif value="Ruanda">Ruanda</option>
                                    <option @if(old('país_de_origem') == "Rússia") selected @endif value="Rússia">Rússia</option>
                                    <option @if(old('país_de_origem') == "Saara Ocidental") selected @endif value="Saara Ocidental">Saara Ocidental</option>
                                    <option @if(old('país_de_origem') == "Saint Martin") selected @endif value="Saint Martin">Saint Martin</option>
                                    <option @if(old('país_de_origem') == "Saint-Barthélemy") selected @endif value="Saint-Barthélemy">Saint-Barthélemy</option>
                                    <option @if(old('país_de_origem') == "Saint-Pierre e Miquelon") selected @endif value="Saint-Pierre e Miquelon">Saint-Pierre e Miquelon</option>
                                    <option @if(old('país_de_origem') == "Samoa Americana") selected @endif value="Samoa Americana">Samoa Americana</option>
                                    <option @if(old('país_de_origem') == "Samoa") selected @endif value="Samoa">Samoa</option>
                                    <option @if(old('país_de_origem') == "Santa Helena, Ascensão e Tristão da Cunha") selected @endif value="Santa Helena, Ascensão e Tristão da Cunha">Santa Helena, Ascensão e Tristão da Cunha</option>
                                    <option @if(old('país_de_origem') == "Santa Lúcia") selected @endif value="Santa Lúcia">Santa Lúcia</option>
                                    <option @if(old('país_de_origem') == "Senegal") selected @endif value="Senegal">Senegal</option>
                                    <option @if(old('país_de_origem') == "Serra Leoa") selected @endif value="Serra Leoa">Serra Leoa</option>
                                    <option @if(old('país_de_origem') == "Seychelles") selected @endif value="Seychelles">Seychelles</option>
                                    <option @if(old('país_de_origem') == "Singapura") selected @endif value="Singapura">Singapura</option>
                                    <option @if(old('país_de_origem') == "Somália") selected @endif value="Somália">Somália</option>
                                    <option @if(old('país_de_origem') == "Sri Lanka") selected @endif value="Sri Lanka">Sri Lanka</option>
                                    <option @if(old('país_de_origem') == "Suazilândia") selected @endif value="Suazilândia">Suazilândia</option>
                                    <option @if(old('país_de_origem') == "Sudão") selected @endif value="Sudão">Sudão</option>
                                    <option @if(old('país_de_origem') == "Suriname") selected @endif value="Suriname">Suriname</option>
                                    <option @if(old('país_de_origem') == "Suécia") selected @endif value="Suécia">Suécia</option>
                                    <option @if(old('país_de_origem') == "Suíça") selected @endif value="Suíça">Suíça</option>
                                    <option @if(old('país_de_origem') == "Svalbard e Jan Mayen") selected @endif value="Svalbard e Jan Mayen">Svalbard e Jan Mayen</option>
                                    <option @if(old('país_de_origem') == "São Cristóvão e Nevis") selected @endif value="São Cristóvão e Nevis">São Cristóvão e Nevis</option>
                                    <option @if(old('país_de_origem') == "São Marino") selected @endif value="São Marino">São Marino</option>
                                    <option @if(old('país_de_origem') == "São Tomé e Príncipe") selected @endif value="São Tomé e Príncipe">São Tomé e Príncipe</option>
                                    <option @if(old('país_de_origem') == "São Vicente e Granadinas") selected @endif value="São Vicente e Granadinas">São Vicente e Granadinas</option>
                                    <option @if(old('país_de_origem') == "Sérvia") selected @endif value="Sérvia">Sérvia</option>
                                    <option @if(old('país_de_origem') == "Síria") selected @endif value="Síria">Síria</option>
                                    <option @if(old('país_de_origem') == "Tadjiquistão") selected @endif value="Tadjiquistão">Tadjiquistão</option>
                                    <option @if(old('país_de_origem') == "Tailândia") selected @endif value="Tailândia">Tailândia</option>
                                    <option @if(old('país_de_origem') == "Taiwan") selected @endif value="Taiwan">Taiwan</option>
                                    <option @if(old('país_de_origem') == "Tanzânia") selected @endif value="Tanzânia">Tanzânia</option>
                                    <option @if(old('país_de_origem') == "Terras Austrais e Antárticas Francesas") selected @endif value="Terras Austrais e Antárticas Francesas">Terras Austrais e Antárticas Francesas</option>
                                    <option @if(old('país_de_origem') == "Território Britânico do Oceano Índico") selected @endif value="Território Britânico do Oceano Índico">Território Britânico do Oceano Índico</option>
                                    <option @if(old('país_de_origem') == "Timor-Leste") selected @endif value="Timor-Leste">Timor-Leste</option>
                                    <option @if(old('país_de_origem') == "Togo") selected @endif value="Togo">Togo</option>
                                    <option @if(old('país_de_origem') == "Tonga") selected @endif value="Tonga">Tonga</option>
                                    <option @if(old('país_de_origem') == "Toquelau") selected @endif value="Toquelau">Toquelau</option>
                                    <option @if(old('país_de_origem') == "Trinidad e Tobago") selected @endif value="Trinidad e Tobago">Trinidad e Tobago</option>
                                    <option @if(old('país_de_origem') == "Tunísia") selected @endif value="Tunísia">Tunísia</option>
                                    <option @if(old('país_de_origem') == "urcas e Caicos") selected @endif value="Turcas e Caicos">Turcas e Caicos</option>
                                    <option @if(old('país_de_origem') == "Turquemenistão") selected @endif value="Turquemenistão">Turquemenistão</option>
                                    <option @if(old('país_de_origem') == "Turquia") selected @endif value="Turquia">Turquia</option>
                                    <option @if(old('país_de_origem') == "Tuvalu") selected @endif value="Tuvalu">Tuvalu</option>
                                    <option @if(old('país_de_origem') == "Ucrânia") selected @endif value="Ucrânia">Ucrânia</option>
                                    <option @if(old('país_de_origem') == "Uganda") selected @endif value="Uganda">Uganda</option>
                                    <option @if(old('país_de_origem') == "Uruguai") selected @endif value="Uruguai">Uruguai</option>
                                    <option @if(old('país_de_origem') == "Uzbequistão") selected @endif value="Uzbequistão">Uzbequistão</option>
                                    <option @if(old('país_de_origem') == "Vanuatu") selected @endif value="Vanuatu">Vanuatu</option>
                                    <option @if(old('país_de_origem') == "Vaticano") selected @endif value="Vaticano">Vaticano</option>
                                    <option @if(old('país_de_origem') == "Venezuela") selected @endif value="Venezuela">Venezuela</option>
                                    <option @if(old('país_de_origem') == "Vietname") selected @endif value="Vietname">Vietname</option>
                                    <option @if(old('país_de_origem') == "Wallis e Futuna") selected @endif value="Wallis e Futuna">Wallis e Futuna</option>
                                    <option @if(old('país_de_origem') == "Zimbabwe") selected @endif value="Zimbabwe">Zimbabwe</option>
                                    <option @if(old('país_de_origem') == "Zâmbia") selected @endif value="Zâmbia">Zâmbia</option>
                                </select>

                                @error('país_de_origem')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div id="div-cpf" class="col-md-6 form-group" style="@if(old('estrangeiro') == "sim") display: none; @else display: block; @endif">
                                <label for="cpf" class="style_campo_titulo">CPF <span id="msg-cpf-obrigatorio" style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('cpf') is-invalid @enderror" id="cpf" name="cpf"
                                    placeholder="Digite seu CPF" value="{{ old('cpf') }}" />
                                @error('cpf')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="telefone" class="style_campo_titulo">Telefone </label>
                                <input type="text" class="form-control style_campo @error('telefone') is-invalid @enderror celular" id="telefone" name="telefone"
                                    placeholder="Digite o seu número de telefone" value="{{ old('telefone') }}"/>
                                @error('telefone')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="celular" class="style_campo_titulo">Celular <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('celular') is-invalid @enderror celular" id="celular" name="celular"
                                    placeholder="Digite o seu número de celular" value="{{ old('celular') }}" required />
                                @error('celular')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <h6 class="style_card_container_header_subtitulo">Endereço</h6>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="cep" class="style_campo_titulo">CEP <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('cep') is-invalid @enderror" id="cep" name="cep"
                                    placeholder="Digite o número do CEP onde mora" value="{{ old('cep') }}" required onblur="pesquisacep(this.value);"/>
                                @error('cep')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="logradouro" class="style_campo_titulo">Logradouro (rua, avenida, etc) <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('logradouro') is-invalid @enderror" id="logradouro" name="logradouro"
                                    placeholder="Digite o nome do seu logradouro" value="{{ old('logradouro') }}" required />
                                @error('logradouro')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="bairro" class="style_campo_titulo">Bairro <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('bairro') is-invalid @enderror" id="bairro" name="bairro"
                                    placeholder="Digite o bairro onde mora" value="{{ old('bairro') }}" required />
                                @error('bairro')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="número" class="style_campo_titulo">Número <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('número') is-invalid @enderror" id="número" name="número"
                                    placeholder="Digite o número de sua casa" value="{{ old('número') }}" required/>
                                @error('número')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="cidade" class="style_campo_titulo">Cidade <span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-control style_campo @error('cidade') is-invalid @enderror" id="cidade" name="cidade"
                                    placeholder="Digite a sua cidade" value="{{ old('cidade') }}" required/>
                                @error('cidade')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="uf" class="style_campo_titulo">UF <span style="color: red; font-weight: bold;">*</span></label></label>
                                <select class="form-control style_campo @error('uf') is-invalid @enderror" id="uf" name="uf">
                                    <option value="" disabled selected hidden>-- Selecione o UF --</option>
                                    <option @if(old('uf') == 'AC') selected @endif value="AC">Acre</option>
                                    <option @if(old('uf') == 'AL') selected @endif value="AL">Alagoas</option>
                                    <option @if(old('uf') == 'AP') selected @endif value="AP">Amapá</option>
                                    <option @if(old('uf') == 'AM') selected @endif value="AM">Amazonas</option>
                                    <option @if(old('uf') == 'BA') selected @endif value="BA">Bahia</option>
                                    <option @if(old('uf') == 'CE') selected @endif value="CE">Ceará</option>
                                    <option @if(old('uf') == 'DF') selected @endif value="DF">Distrito Federal</option>
                                    <option @if(old('uf') == 'ES') selected @endif value="ES">Espírito Santo</option>
                                    <option @if(old('uf') == 'GO') selected @endif value="GO">Goiás</option>
                                    <option @if(old('uf') == 'MA') selected @endif value="MA">Maranhão</option>
                                    <option @if(old('uf') == 'MT') selected @endif value="MT">Mato Grosso</option>
                                    <option @if(old('uf') == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                    <option @if(old('uf') == 'MG') selected @endif value="MG">Minas Gerais</option>
                                    <option @if(old('uf') == 'PA') selected @endif value="PA">Pará</option>
                                    <option @if(old('uf') == 'PB') selected @endif value="PB">Paraíba</option>
                                    <option @if(old('uf') == 'PR') selected @endif value="PR">Paraná</option>
                                    <option @if(old('uf') == 'PE') selected @endif value="PE">Pernambuco</option>
                                    <option @if(old('uf') == 'PI') selected @endif value="PI">Piauí</option>
                                    <option @if(old('uf') == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                    <option @if(old('uf') == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                    <option @if(old('uf') == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                    <option @if(old('uf') == 'RO') selected @endif value="RO">Rondônia</option>
                                    <option @if(old('uf') == 'RR') selected @endif value="RR">Roraima</option>
                                    <option @if(old('uf') == 'SC') selected @endif value="SC">Santa Catarina</option>
                                    <option @if(old('uf') == 'SP') selected @endif value="SP">São Paulo</option>
                                    <option @if(old('uf') == 'SE') selected @endif value="SE">Sergipe</option>
                                    <option @if(old('uf') == 'TO') selected @endif value="TO">Tocantins</option>
                                </select>
                                @error('UF')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="complemento" class="style_campo_titulo">Complemento </label>
                                <textarea type="text" class="form-control style_campo @error('complemento') is-invalid @enderror" id="complemento" name="complemento"
                                    placeholder="Digite o complemento onde mora">{{ old('complemento') }}</textarea>
                                @error('complemento')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-bottom: 5px;">
                            <hr>
                        </div>
                        <div class="col-md-12 form-group" style="margin-bottom: 9px;">
                            <button class="btn btn-success shadow-sm" style="width: 100%;">Cadastre-se</button>
                            <h6 style="font-size: 13px; color: #909090; font-weight: normal; margin-top: 15px; margin-bottom: -10px;">Ao clicar em Cadastre-se, você concorda com nossos Termos e Política de Cookies. </h6>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function($) {
        $('#cpf').mask('00000000000');
        var SPMaskBehavior = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        $('.celular').mask(SPMaskBehavior, spOptions);
        $('#cep').mask('00000-000');
        $("#nome").mask("#", {
            maxlength: true,
            translation: {
                '#': { pattern: /^[A-Za-záâãéêíóôõúçÁÂÃÉÊÍÓÔÕÚÇ\s]+$/, recursive: true }
            }
        });
        $("#sobrenome").mask("#", {
            maxlength: true,
            translation: {
                '#': { pattern: /^[A-Za-záâãéêíóôõúçÁÂÃÉÊÍÓÔÕÚÇ\s]+$/, recursive: true }
            }
        });
        $("#nome_do_pai").mask("#", {
            maxlength: true,
            translation: {
                '#': { pattern: /^[A-Za-záâãéêíóôõúçÁÂÃÉÊÍÓÔÕÚÇ\s]+$/, recursive: true }
            }
        });
        $("#nome_do_mãe").mask("#", {
            maxlength: true,
            translation: {
                '#': { pattern: /^[A-Za-záâãéêíóôõúçÁÂÃÉÊÍÓÔÕÚÇ\s]+$/, recursive: true }
            }
        });
    });
    function exibirMsg(input) {
        if (input.value == "sim") {
            document.getElementById('msg-estrangeiro-pasaporte').style.display = "inline";
            document.getElementById('msg-cpf-obrigatorio').style.display = "none";
            document.getElementById('div-orgao-emissor').style.display = "none";
            document.getElementById('div-cpf').style.display = "none";
            limparCampos();
            selecionarPais("");
        } else {
            document.getElementById('msg-estrangeiro-pasaporte').style.display = "none";
            document.getElementById('msg-cpf-obrigatorio').style.display = "inline";
            document.getElementById('div-orgao-emissor').style.display = "block";
            document.getElementById('div-cpf').style.display = "block";
            limparCampos();
            selecionarPais("Brasil");
        }
    }
    function selecionarPais(pais) {
        var select = document.getElementById('país_de_origem');
        var input = document.getElementById('país_de_origem_input_hidden');
        if (pais == "Brasil") {
            select.disabled = true;
        } else {
            select.disabled = false;
        }
        select.value = pais;
        input.value = pais;
    }
    function setarInputPais(select) {
        var input = document.getElementById('país_de_origem_input_hidden');
        input.value = select.value;
    }
    function limparCampos() {
        document.getElementById('cpf').value = "";
        document.getElementById('órgao_emissor').value = "";
        document.getElementById('documento_de_identificação').value = "";
        selecionarPais("");
    }
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('logradouro').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }
    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('logradouro').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
    function pesquisacep(valor) {
        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('logradouro').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                //Cria um elemento javascript.
                var script = document.createElement('script');
                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };
    function visualizarSenha(button) {
        var img = button.children[0];
        var input = button.parentElement.parentElement.children[0];
        if (input.type == "password") {
            input.type = "text";
            img.src =  "{{asset('img/icon_no_visualizar_white.svg')}}";
        } else {
            input.type = "password";
            img.src = "{{asset('img/icon_visualizar_white.svg')}}";
        }
    }
    function alterarImagem(button) {
        var img = button.children[0];
        var input = button.parentElement.parentElement.children[0];
        if (img.src == "{{asset('img/icon_visualizar_cinza.svg')}}") {
            img.src = "{{asset('img/icon_visualizar_white.svg')}}";
        } else if (img.src == "{{asset('img/icon_visualizar_white.svg')}}") {
            img.src = "{{asset('img/icon_visualizar_cinza.svg')}}";
        }
        if (img.src == "{{asset('img/icon_no_visualizar_cinza.svg')}}") {
            img.src = "{{asset('img/icon_no_visualizar_white.svg')}}";
        } else if (img.src == "{{asset('img/icon_no_visualizar_white.svg')}}") {
            img.src = "{{asset('img/icon_no_visualizar_cinza.svg')}}";
        }
    }
</script>
@endsection