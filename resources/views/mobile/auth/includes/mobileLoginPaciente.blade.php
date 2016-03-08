<div class="w-form formPaciente">
    <form id="submit-form" name="email-form" action="#" data-redirect="assets/manhattan/testePaciente.blade.php">
        <div>
        <div class="separator-button"></div><a class="link-right" id="linkCliente">Acessar com <strong class="b-link">CPF</strong></a>
            <label class="label-form light" for="email-field">Atendimento</label>
            <input class="w-input input-form light" id="email-field" type="text" name="email" value="00/2053" data-name="email" required="required">
            <div class="separator-fields"></div>
        </div>
        <div>
            <label class="label-form light" for="email">Senha</label>
            <div class="block-input-combined">
                <input class="w-input input-form light left" id="password-field" type="password" value="password" name="password" data-name="password" required="required"> </div>
            <div class="separator-button-input"></div>
        </div>
        <input class="w-button action-button" type="submit" value="Acessar" data-wait="Please wait...">
        <div class="separator-button"></div><a class="link-upper" id="linkMedico">Acessar como <strong class="b-link">Médico</strong></a> </form>
</div>

<div class="w-form formCliente">
    <form id="submit-form" name="email-form" action="#" data-redirect="home.html">
        <div>
        <div class="separator-button"></div><a class="link-right" id="linkClientePaciente">Acessar com <strong class="b-link">ID/Atendimento</strong></a>
            <label class="label-form light" for="email-field">CPF</label>
            <input class="w-input input-form light" id="email-field" type="text" name="email" value="188.657.478-89" data-name="email" required="required">
            <div class="separator-fields"></div>
        </div>
        <div>
            <label class="label-form light" for="email">Data de Nascimento</label>
            <div class="block-input-combined">
                <input class="w-input input-form light left" id="dataNasc" type="date" value="1992-10-02" name="dataNasc" data-name="password" required="required"> </div>
        </div>
        <div>
            <label class="label-form light" for="email">Senha</label>
            <div class="block-input-combined">
                <input class="w-input input-form light left" id="password-field" type="password" value="password" name="password" data-name="password" required="required"> </div>
            <div class="separator-button-input"></div>
        </div>
        <input class="w-button action-button" type="submit" value="Acessar" data-wait="Please wait...">
        <div class="separator-button"></div><a class="link-upper" id="linkClienteMedico">Acessar como <strong class="b-link">Médico</strong></a> </form>
</div>