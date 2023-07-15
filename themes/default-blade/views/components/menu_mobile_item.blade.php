{% for item in items %}
<li class="nav-item {% if item.children %} dropdown {% endif %}">
    <a class="nav-link active {% if item.children %} dropdown-toggle {% endif %} text-dark" href="{{ item.link }}" {% if item.children %} data-toggle="dropdown" {% endif %}>
        {{ item.label }}
    </a>

    {% if item.children %}
    <ul class="dropdown-menu dropdown-menu-left">
        {% for child in item.children %}
        <li>
            <a class="dropdown-item text-dark" href="{{ child.link }}">{{ child.label }}</a>
        </li>
        {% endfor %}
    </ul>
    {% endif %}
</li>
{% endfor %}

