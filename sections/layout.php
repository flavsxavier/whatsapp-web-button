<table class="form-table">
    <tr>
        <th scope="row">
            <label for="wwb__modes">Ícone</label>
        </th>
        <td>
            <select name="wwb__icon" id="wwb__modes">
                <option value="default" <?php selected(get_option('wwb__icon'), 'default'); ?>>Padrão</option>
                <option value="business" <?php selected(get_option('wwb__icon'), 'business'); ?>>Business</option>
                <option value="custom" <?php selected(get_option('wwb__icon'), 'custom'); ?>>Personalizado</option>
            </select>
        </td>
    </tr>
    <tr class="wwb__custom_icon hidden">
        <th scope="row">
            <label for="wwb__file_id">Escolher ícone</label>
        </th>
        <td>
            <input type="text" name="wwb__file" id="wwb__file_id" class="wwb__file_input" size="60" value="<?php echo get_option('wwb__file'); ?>">
            <a href="#" class="wwb__file_btn button button-primary">Upload</a>
            <h4>Visualização</h4>
            <img src="<?php echo get_option('wwb__file'); ?>" class="icon-preview" alt="Visualização do ícone">
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="wwb__position_id">Posição</label>
        </th>
        <td>
            <h4>Desktop</h4>
            <select name="wwb__position" id="wwb__position_id">
                <option value="none" <?php selected(get_option('wwb__position'), "none"); ?>>Não exibir nesses dispositivos</option>
                <option value="right" <?php selected(get_option('wwb__position'), "right"); ?>>Direita</option>
                <option value="left" <?php selected(get_option('wwb__position'), "left"); ?>>Esquerda</option>
            </select>
            <h4>Mobile</h4>
            <select name="wwb__mbposition" id="wwb__mbposition_id">
                <option value="none" <?php selected(get_option('wwb__mbposition'), "none"); ?>>Não exibir nesses dispositivos</option>
                <option value="right top" <?php selected(get_option('wwb__mbposition'), "right top"); ?>>Topo - Direita</option>
                <option value="left top" <?php selected(get_option('wwb__mbposition'), "left top"); ?>>Topo - Esquerda</option>
                <option value="bottom right" <?php selected(get_option('wwb__mbposition'), "bottom right"); ?>>Baixo - Direita</option>
                <option value="bottom left" <?php selected(get_option('wwb__mbposition'), "bottom left"); ?>>Baixo - Esquerda</option>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for=" wwb__tooltip_id">Tooltip</label>
            <p class="description">Texto que aparece quando o mouse está sob o ícone.</p>
        </th>
        <td>
            <h4>Texto</h4>
            <input type="text" name="wwb__tooltip" id="wwb__tooltip_id" class="regular-text" value="<?php echo get_option('wwb__tooltip'); ?>"><br/><br/>
            <h4>Posição</h4>
            <select name="wwb__tooltip_pos" id="wwb__tooltip_pos_id">
                <option value="none" <?php selected(get_option('wwb__tooltip_pos'), "none"); ?>>Não Exibir</option>
                <option value="top" <?php selected(get_option('wwb__tooltip_pos'), "top"); ?>>Topo</option>
                <option value="right" <?php selected(get_option('wwb__tooltip_pos'), "right"); ?>>Direita</option>
                <option value="bottom" <?php selected(get_option('wwb__tooltip_pos'), "bottom"); ?>>Baixo</option>
                <option value="left" <?php selected(get_option('wwb__tooltip_pos'), "left"); ?>>Esquerda</option>
            </select>
        </td>
    </tr>
</table>