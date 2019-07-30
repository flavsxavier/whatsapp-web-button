<table class="form-table">
    <tbody>
        <tr class="wwb__multi_input">
            <th scope="row">
                <label for="wwb__mlabel_id">Adicionar números</label>
            </th>
            <td>
                <h4>Descrição</h4>
                <input type="text" name="wwb__multi_label" id="wwb__mlabel_id" class="regular-text">
                <p class="description">A descrição, ou "nome", funciona como uma <strong>ID</strong>, portanto <strong>não</strong> pode haver "nomes" iguais.</p>
                <h4>Número</h4>
                <input type="text" name="wwb__multi_tel" id="wwb__mnumber_id" class="regular-text"> 
                <p class="submit multi__n">
                    <a id="add__mnumbers_btn" class="button button-secondary">Adicionar número</a>
                    <a id="clean__mnumbers_btn" class="button button-secondary">Limpar números</a>
                </p>
                <h4>Números adicionados temporariamente</h4>
                <p class="description"><strong>Atenção!</strong> Números a seguir foram adicionados apenas temporariamente. Após adicionar todos, salve as alterações para adicioná-los definitivamente.
                <div class="mnumbers-preview">
                    <p>Não há números adicionados ainda.</p>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<p class="submit">
    <a id="save__mnumbers_btn" class="button button-primary">Salvar alterações</a>
</p>
<div id="wwbtn__table">
    <h2><span class="dashicons dashicons-yes-alt"></span>Números salvos</h2>
    <table id="table__multi_tel" class="display">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Número</th>
                <th>  </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $multi_numbers = get_option('wwb__multi_numbers');
                foreach ($multi_numbers as $key) {
                    echo '<tr>';
                    echo '<td>' . $key[0] . '</td>';
                    echo '<td>' . $key[1] . '</td>';
                    echo '<td><a data-label="'. $key[0] .'" class="delete__number"><span class="dashicons dashicons-trash"></span></a></td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>