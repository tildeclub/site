function Header(elem)
    table.insert(elem.content, pandoc.Space())
    table.insert(elem.content, pandoc.Link("🔗", "#" .. elem.identifier))
    return elem
end

