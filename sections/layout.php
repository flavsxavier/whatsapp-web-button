<table class="form-table">
    <tr>
        <th scope="row">
            <label for="wwb__modes">Ícone</label>
        </th>
        <td>
            <h4>Estilo</h4>
            <select name="wwb__icon" id="wwb__modes">
                <option value="default" <?php selected(get_option('wwb__icon'), 'default'); ?>>Padrão</option>
                <option value="business" <?php selected(get_option('wwb__icon'), 'business'); ?>>Business</option>
                <option value="custom" <?php selected(get_option('wwb__icon'), 'custom'); ?>>Personalizado</option>
            </select>
            <div class="wwb__icon_size">
                <h4>Tamanho</h4>
                <select name="wwb__icon_size">
                    <option value="small" <?php selected(get_option('wwb__icon_size'), 'small'); ?>>Pequeno</option>
                    <option value="default" <?php selected(get_option('wwb__icon_size'), 'default'); ?>>Normal</option>
                    <option value="large" <?php selected(get_option('wwb__icon_size'), 'large'); ?>>Grande</option>
                </select>
            </div>
            <div class="wwb__custom_icon hidden">
                <h4 class="wwb__custom_icon">Enviar ícone customizado</h4>
                <input type="text" name="wwb__file" id="wwb__file_id" class="wwb__file_input" size="60" value="<?php echo get_option('wwb__file'); ?>">
                <a href="#" class="wwb__file_btn button button-primary">Upload</a>
                <?php if (!empty(get_option('wwb__file'))) : ?>
                    <h4>Visualização</h4>
                    <img src="<?php echo get_option('wwb__file'); ?>" class="icon-preview" alt="Visualização do ícone">
                <?php endif; ?>
            </div>
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
            <label for=" wwb__tooltip_id">Título do modal e Tooltip</label>
            <p class="description">Título do modal e texto que aparecerá quando o mouse estiver sob o ícone.</p>
        </th>
        <td>
            <h4>Texto</h4>
            <input type="text" name="wwb__tooltip" id="wwb__tooltip_id" class="regular-text" value="<?php echo get_option('wwb__tooltip'); ?>"><br/><br/>
        </td>
    </tr>
</table>