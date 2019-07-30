<table class="form-table">
    <tbody>
        <tr>
            <th scope="row">Manter WhatsApp Web Button</th>
            <td>
                <fieldset>
                    <label>
                        <input type="radio" name="wwb__status" id="wwb__status_act" value="activated" <?php checked(get_option('wwb__status'), 'activated') ?> required>
                        <span>Ativado</span>
                    </label>
                    <br/>
                    <label>
                        <input type="radio" name="wwb__status" id="wpp__status_dea" value="deactivated" <?php checked(get_option('wwb__status'), 'deactivated') ?> required>
                        <span>Desativado</span>
                    </label>
                </fieldset>
            </td>
        </tr>
        <tr class="wwb__single_tel">
            <th scope="row">
                <label for="wwb__tel_id">Número</label>
            </th>
            <td>
                <input type="text" name="wwb__telefone" id="wwb__tel_id" class="regular-text" value="<?php echo get_option('wwb__telefone'); ?>">
            </td>
        </tr> 
        <tr>
            <th scope="row">
                <h2><span class="dashicons dashicons-text-page"></span>Múltiplos números</h2>
            </th>
            <td><p><strong>Permite configurar e usar vários números. Vem desativado por padrão.</strong></p></td>
        </tr>
        <tr>
            <th scope="row">Usar Múltiplos Números</th>
            <td>
                <fieldset>
                    <label>
                        <input type="radio" name="wwb__multi_status" id="wpp__multi_stact" value="activated" <?php checked(get_option('wwb__multi_status'), 'activated'); ?>>
                        <span>Sim</span>
                    </label>
                    <br/>
                    <label>
                        <input type="radio" name="wwb__multi_status" id="wpp__multi_stdea" value="deactivated" <?php checked(get_option('wwb__multi_status'), 'deactivated'); ?>>
                        <span>Não</span>
                    </label>
                </fieldset>
            </td>
        </tr>
    </tbody>
</table>