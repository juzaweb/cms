{% for item in items %}
    <li class="nav-item {% if item.children %} dropdown has-submenu menu-large hidden-md-down hidden-sm-down hidden-xs-down {% endif %}">
        <a class="nav-link {% if item.children %} dropdown-toggle {% endif %}" href="{{ item.link }}" {% if item.children %} id="dropdown-{{ item.id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" {% endif %}>{{ item.label }}</a>

        {% if item.children %}
            <ul class="dropdown-menu megamenu" aria-labelledby="dropdown-{{ item.id }}">
                {% for child in item.children %}
                    {% include 'theme::components.menu_item' with {'items': item.children} %}
                {% endfor %}
            </ul>
        {% endif %}
    </li>
{% endfor %}